<?php
/**
 * @author Vitaliy Ofat <ofatv22@gmail.com>
 */

namespace site\modules\cabinet\controllers;

use Yii;
use yii\filters\AccessControl;

use site\modules\cabinet\CabinetController;

class AddressController extends CabinetController
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['index','add','edit','remove'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        return $this->render('index');
    }
}