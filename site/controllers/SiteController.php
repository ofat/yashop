<?php
namespace yashop\site\controllers;

use yashop\common\helpers\Config;
use yashop\common\models\Language;
use Yii;
use yii\base\InvalidParamException;
use yii\db\Query;
use yii\web\Controller;

/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    public function actionIndex()
    {
        return $this->render('index.twig');
    }

    public function actionAbout()
    {
        return $this->render('about');
    }

    public function actionLanguage($id)
    {
        $id = (int)$id;
        $isActive = (new Query())
            ->select('id')
            ->from(Language::tableName())
            ->where(['id'=>$id,'is_active'=>'1'])
            ->scalar();

        if(!$isActive)
            throw new InvalidParamException;

        Config::setLanguage($id);

        return $this->goBack();
    }

}
