<?php

namespace site\modules\cabinet\controllers;

use Yii;
use yii\filters\AccessControl;

use site\modules\cabinet\CabinetController;
use site\modules\cabinet\models\forms\ChangeEmailForm;

class ProfileController extends CabinetController
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['email','password'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    public function actionEmail()
    {
        $model = new ChangeEmailForm;

        if($model->load(Yii::$app->request->post()) && $model->changeEmail()) {
            Yii::$app->session->setFlash('success', Yii::t('cabinet/profile','E-mail successfully changed.'));
            return $this->redirect(['/cabinet']);
        }

        return $this->render('email',[
            'model' => $model
        ]);
    }

    public function actionPassword()
    {
        return $this->render('password');
    }

}
