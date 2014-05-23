<?php

namespace yashop\admin\modules\widgets\controllers;

use yashop\common\components\BaseController;
use yashop\common\models\Language;
use yashop\common\models\widgets\WidgetMenuDescription;
use Yii;
use yashop\common\models\widgets\Widget;
use yashop\common\models\widgets\WidgetMenuItem;
use yii\base\Model;
use yii\db\Query;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use yii\web\HttpException;
use yii\web\NotFoundHttpException;

class MenuController extends BaseController
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['index', 'add', 'edit', 'remove', 'move'],
                        'allow' => true,
                        'roles' => ['admin'],
                    ]
                ],
            ]
        ];
    }

    /**
     * @param $id
     * @return string
     */
    public function actionAdd($id)
    {
        return $this->form($id);
    }

    /**
     * @param $menu_id
     * @param $id
     * @return string|\yii\web\Response
     */
    public function actionEdit($menu_id, $id)
    {
        return $this->form($menu_id, $id);
    }

    /**
     * Renders form for adding/editing menu item
     * @param $menu_id
     * @param int $id
     * @return string|\yii\web\Response
     * @throws HttpException
     */
    protected function form($menu_id, $id = 0)
    {
        list($menuTypes,$menus) = $this->getMenuTypes();
        $listMenu = [];
        /**
         * @var \yashop\common\models\widgets\Widget $item
         */
        foreach($menus as $item)
        {
            $listMenu[$item->id] = $item->description->name;
        }
        $menu = $this->getMenuModel($menu_id);

        $model = $this->getItemModel($id);
        $model->widget_id = $menu->id;

        $description = ArrayHelper::index($model->allDescription, 'language_id');
        $languages = Language::getActive();
        foreach($languages as $language)
        {
            if(isset($description[ $language->id ]))
                continue;

            $description[ $language->id ] = new WidgetMenuDescription;
            $description[ $language->id ]->language_id = $language->id;
            $description[ $language->id ]->item_id = $model->id;
        }

        $post = Yii::$app->request->post();
        $itemLoaded = $model->load($post) && $model->validate();
        $descriptionLoaded = Model::loadMultiple($description, $post);

        if($itemLoaded && $descriptionLoaded) {
            $transaction = Yii::$app->db->beginTransaction();
            try {
                if($model->parent_id == 0)
                    $model->parent_id = null;
                if(!$model->sort_order)
                {
                    $last = (new Query())
                            ->select('MAX(sort_order)')
                            ->from(WidgetMenuItem::tableName())
                            ->where(['widget_id'=>$model->widget_id, 'parent_id'=>$model->parent_id])
                            ->scalar();
                    $model->sort_order = ++$last;
                }
                $r = $model->save();
                if(!$r)
                    die($model->getErrors());
                foreach($description as $item)
                {
                    $item->item_id = $model->id;
                    $r = $item->save() && $r;
                }
                if($r) {
                    $transaction->commit();
                    return $this->redirect(['/widgets/menu/index', 'id'=>$model->widget_id]);
                }
                else
                    throw new HttpException(500, Yii::t('base', 'Saving error. Please try again'));
            } catch(Exception $e) {
                $transaction->rollBack();
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }

        return $this->render('form', [
            'menuTypes' => $menuTypes,
            'menu' => $menu,
            'model' => $model,
            'listMenu' => $listMenu,
            'languages' => $languages,
            'description' => $description
        ]);
    }

    /**
     * @param bool $id
     * @return string
     */
    public function actionIndex($id = false)
    {
        list($menuTypes) = $this->getMenuTypes();
        if(!$id)
        {
            $menu = false;
            $items = [];
        } else {
            $menu = $this->getMenuModel($id);
            $items = $menu->getMenuItems();
        }
        return $this->render('index', ['menuTypes' => $menuTypes, 'menu'=>$menu, 'items'=>$items]);
    }

    /**
     * @param $id
     * @param string $dir
     * @return \yii\web\Response
     */
    public function actionMove($id, $dir = 'up')
    {
        $item = $this->getItemModel($id);
        $up = ($dir == 'up');
        $near = WidgetMenuItem::find()->where(['menu_id'=>$item->menu_id, 'parent_id'=>$item->parent_id]);
        if($up) {
            $near = $near->andWhere('sort_order < :sort',[':sort'=>$item->sort_order])->orderBy('sort_order DESC')->one();
        } else {
            $near = $near->andWhere('sort_order > :sort',[':sort'=>$item->sort_order])->orderBy('sort_order ASC')->one();
        }

        if($near) {
            $tmp = $item->sort_order;
            $item->sort_order = $near->sort_order;
            $item->save();
            $near->sort_order = $tmp;
            $near->save();
        }

        return $this->redirect(['index', 'id'=>$item->menu_id]);
    }

    /**
     * @param $id
     * @return \yii\web\Response
     */
    public function actionRemove($id)
    {
        $item = $this->getItemModel($id);
        $menu_id = $item->widget_id;
        $item->delete();
        return $this->redirect(['index', 'id'=>$menu_id]);
    }

    /**
     * @return array
     */
    protected function getMenuTypes()
    {
        $listMenu = Widget::find()->where(['type_id'=>Widget::TYPE_MENU])->all();
        $menuTypes = [];
        foreach($listMenu as $item)
        {
            /**
             * @var $item Widget
             */
            $menuTypes[] = ['label' => $item->description->name, 'url' => ['/widgets/menu/index', 'id'=>$item->id]];
        }

        return [$menuTypes, $listMenu];
    }

    /**
     * @param $id
     * @return \yashop\common\models\widgets\Widget
     * @throws \yii\web\NotFoundHttpException
     */
    protected function getMenuModel($id)
    {
        $menu = Widget::findOne($id);
        if(!$menu)
            throw new NotFoundHttpException(Yii::t('base', 'The requested page does not exist.'));

        return $menu;
    }

    /**
     * @param $id
     * @return WidgetMenuItem
     * @throws \yii\web\NotFoundHttpException
     */
    protected function getItemModel($id)
    {
        if($id == 0)
            return new WidgetMenuItem;

        $menu = WidgetMenuItem::findOne($id);
        if(!$menu)
            throw new NotFoundHttpException(Yii::t('base', 'The requested page does not exist.'));

        return $menu;
    }

}
