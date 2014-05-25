<?php

namespace yashop\site\modules\catalog\controllers;

use yii\sphinx\Query;
use yii\web\Controller;
use yii\data\ActiveDataProvider;
use yashop\site\modules\catalog\models\ItemSearch;

class DefaultController extends Controller
{
    public function actionIndex()
    {
        //$query = new Query();
        //$query->from('itemIndex')->match('omnis')->filterWhere(['language_id' => 1]);

        $query = ItemSearch::find();
        $query->andFilterWhere([
            'category_id' => 188
        ]);
        $provider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 10,
            ]
        ]);
        echo 'items:';
        $models = $provider->getModels();
        foreach($models as $model) {
            echo '<pre>'; print_r($model);
        }
        exit;
        return $this->render('index');
    }
}
