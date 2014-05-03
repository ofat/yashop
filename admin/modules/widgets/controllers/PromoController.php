<?php

namespace yashop\admin\modules\widgets\controllers;

use Yii;
use yashop\common\models\widgets\WidgetPromo;
use yashop\common\models\widgets\WidgetPromoItem;
use yii\db\Query;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class PromoController extends Controller
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
                        'actions' => ['index', 'add', 'remove', 'move'],
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
        list($promoTypes,$promos) = $this->getPromoTypes();
        $listPromo = [];
        /**
         * @var \yashop\common\models\widgets\WidgetPromo $item
         */
        foreach($promos as $item)
        {
            $listPromo[$item->id] = $item->getName();
        }
        $promo = $this->getPromoModel($id);

        $model = new WidgetPromoItem;
        $model->promo_id = $promo->id;

        if($model->load(Yii::$app->request->post())) {
            if(!$model->sort_order)
            {
                $last = (new Query())
                        ->select('MAX(sort_order)')
                        ->from(WidgetPromoItem::tableName())
                        ->where(['promo_id'=>$model->promo_id])
                        ->scalar();
                $model->sort_order = ++$last;
            }
            if($model->save())
                return $this->redirect(['/widgets/promo/index', 'id'=>$model->promo_id]);
        }

        return $this->render('form', ['promoTypes'=>$promoTypes, 'promo'=>$promo, 'model'=>$model, 'listPromo'=>$listPromo]);
    }

    /**
     * @param bool $id
     * @return string
     */
    public function actionIndex($id = false)
    {
        list($promoTypes) = $this->getPromoTypes();
        if(!$id)
        {
            $promo = false;
            $items = [];
        } else {
            $promo = $this->getPromoModel($id);
            $items = $promo->getItems();
        }
        return $this->render('index', ['promoTypes' => $promoTypes, 'promo'=>$promo, 'items'=>$items]);
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
        $near = WidgetPromoItem::find()->where(['promo_id'=>$item->promo_id]);
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

        return $this->redirect(['index', 'id'=>$item->promo_id]);
    }

    /**
     * @param $id
     * @return \yii\web\Response
     */
    public function actionRemove($id)
    {
        $item = $this->getItemModel($id);
        $promo_id = $item->promo_id;
        $item->delete();
        return $this->redirect(['index', 'id'=>$promo_id]);
    }

    /**
     * @return array
     */
    protected function getPromoTypes()
    {
        $listPromo = WidgetPromo::find()->all();
        $promoTypes = [];
        foreach($listPromo as $item)
        {
            $promoTypes[] = ['label' => $item->{Yii::$app->language}, 'url' => ['/widgets/promo/index', 'id'=>$item->id]];
        }

        return [$promoTypes, $listPromo];
    }

    /**
     * @param $id
     * @return \yashop\common\models\widgets\WidgetPromo
     * @throws \yii\web\NotFoundHttpException
     */
    protected function getPromoModel($id)
    {
        $promo = WidgetPromo::findOne($id);
        if(!$promo)
            throw new NotFoundHttpException(Yii::t('base', 'The requested page does not exist.'));

        return $promo;
    }

    /**
     * @param $id
     * @return WidgetPromo|static
     * @throws \yii\web\NotFoundHttpException
     */
    protected function getItemModel($id)
    {
        if($id == 0)
            return new WidgetPromoItem;

        $promo = WidgetPromoItem::findOne($id);
        if(!$promo)
            throw new NotFoundHttpException(Yii::t('base', 'The requested page does not exist.'));

        return $promo;
    }

}
