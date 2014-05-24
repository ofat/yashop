<?php
/**
 * @author Vitaliy Ofat <ofatv22@gmail.com>
 */

namespace yashop\site\modules\cart\controllers;

use yashop\common\components\BaseController;
use yashop\common\models\cart\Cart;
use yashop\common\models\cart\CartItem;
use yii\filters\AccessControl;
use Yii;

class FavoriteController extends BaseController
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['add'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    public function actionAdd()
    {
        $id = Yii::$app->request->get('id');
        $userId = Yii::$app->user->id;
        $items = CartItem::find()->where(['sku_id' => $id, 'user_id' => $userId])->all();
        $r = true;
        foreach($items as $item)
        {
            $r = $item->moveToFavorite() && $r;
        }
        return $r;
    }
}