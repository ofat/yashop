<?php

namespace yashop\admin\modules\settings\controllers;

use yashop\admin\models\forms\SettingForm;
use yashop\common\components\BaseController;
use yashop\common\models\Setting;
use yii\base\Model;
use Yii;

class DefaultController extends BaseController
{
    public function actionIndex()
    {
        $settings = Setting::find()->all();
        $models = [];
        foreach($settings as $i=>$setting)
        {
            $model = new SettingForm;
            $model->id = $setting->id;
            $model->label = $setting->label;
            $model->type = $setting->type;
            $model->value = $setting->value;

            $models[$i] = $model;
        }

        if (Model::loadMultiple($models, Yii::$app->request->post()) && Model::validateMultiple($models)) {
            foreach($models as $i=>$model) {
                $settings[$i]->value = $model->value;
                $settings[$i]->save();
            }
            Yii::$app->session->setFlash('success', Yii::t('base', 'Data successfully saved'));
            $this->redirect(['index']);
        }

        return $this->render('index', ['models' => $models]);
    }
}
