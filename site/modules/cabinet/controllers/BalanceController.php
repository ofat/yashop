<?php
/**
 * @author Vitaliy Ofat <ofatv22@gmail.com>
 */

namespace yashop\site\modules\cabinet\controllers;

use Yii;
use yii\filters\AccessControl;
use yashop\common\models\user\Payment;

use yashop\site\modules\cabinet\components\CabinetController;
use yii\web\NotFoundHttpException;

class BalanceController extends CabinetController
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['index','payment','withdraw'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    /**
     * History of user payments
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionPayment()
    {
        return $this->render('payment');
    }

    public function actionWithdraw()
    {
        return $this->render('withdraw');
    }

}
