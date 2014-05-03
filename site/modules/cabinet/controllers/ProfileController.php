<?php

namespace yashop\site\modules\cabinet\controllers;

use yashop\site\modules\cabinet\models\forms\ChangePasswordForm;
use Yii;
use yii\filters\AccessControl;

use yashop\site\modules\cabinet\CabinetController;
use yashop\site\modules\cabinet\models\forms\ChangeEmailForm;

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
        $model = new ChangePasswordForm;

        if($model->load(Yii::$app->request->post()) && $model->changePassword()) {
            Yii::$app->session->setFlash('success', Yii::t('cabinet/profile','Password successfully changed.'));
            return $this->redirect(['/cabinet']);
        }

        return $this->render('password', [
            'model' => $model
        ]);
    }

}
