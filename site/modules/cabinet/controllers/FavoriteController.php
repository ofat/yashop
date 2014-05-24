<?php
/**
 * @author Vitaliy Ofat <ofatv22@gmail.com>
 */

namespace yashop\site\modules\cabinet\controllers;

use yashop\common\models\search\FavoriteSearch;
use yashop\site\modules\cabinet\components\CabinetController;
use yii\filters\AccessControl;
use Yii;

class FavoriteController extends CabinetController
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['index','remove'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        $searchModel = new FavoriteSearch();
        $params = [
            'FavoriteSearch' => [
                'user_id' => Yii::$app->user->id,
            ]
        ];
        $dataProvider = $searchModel->search($params);

        return $this->render('index', [
            'data' => $dataProvider
        ]);
    }
}