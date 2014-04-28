<?php

namespace admin\modules\widgets\controllers;

use Yii;
use common\models\widgets\WidgetMenu;
use common\models\widgets\WidgetMenuItem;
use yii\db\Query;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\HttpException;
use yii\web\NotFoundHttpException;

class MenuController extends Controller
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
     */
    protected function form($menu_id, $id = 0)
    {
        list($menuTypes,$menus) = $this->getMenuTypes();
        $listMenu = [];
        /**
         * @var \common\models\widgets\WidgetMenu $item
         */
        foreach($menus as $item)
        {
            $listMenu[$item->id] = $item->getName();
        }
        $menu = $this->getMenuModel($menu_id);

        $model = $this->getItemModel($id);
        $model->menu_id = $menu->id;

        if($model->load(Yii::$app->request->post())) {
            if($model->parent_id == 0)
                $model->parent_id = null;
            if(!$model->sort_order)
            {
                $last = (new Query())
                        ->select('MAX(sort_order)')
                        ->from(WidgetMenuItem::tableName())
                        ->where(['menu_id'=>$model->menu_id, 'parent_id'=>$model->parent_id])
                        ->scalar();
                $model->sort_order = ++$last;
            }
            if($model->save())
                return $this->redirect(['/widgets/menu/index', 'id'=>$model->menu_id]);
        }

        return $this->render('form', ['menuTypes'=>$menuTypes, 'menu'=>$menu, 'model'=>$model, 'listMenu'=>$listMenu]);
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
            $items = $menu->getItems();
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
        $menu_id = $item->menu_id;
        $item->delete();
        return $this->redirect(['index', 'id'=>$menu_id]);
    }

    /**
     * @return array
     */
    protected function getMenuTypes()
    {
        $listMenu = WidgetMenu::find()->all();
        $menuTypes = [];
        foreach($listMenu as $item)
        {
            $menuTypes[] = ['label' => $item->{Yii::$app->language}, 'url' => ['/widgets/menu/index', 'id'=>$item->id]];
        }

        return [$menuTypes, $listMenu];
    }

    /**
     * @param $id
     * @return \common\models\widgets\WidgetMenu
     * @throws \yii\web\NotFoundHttpException
     */
    protected function getMenuModel($id)
    {
        $menu = WidgetMenu::findOne($id);
        if(!$menu)
            throw new NotFoundHttpException(Yii::t('base', 'The requested page does not exist.'));

        return $menu;
    }

    /**
     * @param $id
     * @return WidgetMenu|static
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
