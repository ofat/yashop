<?php

namespace yashop\admin\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yashop\common\models\Country;

/**
 * CountrySearch represents the model behind the search form about `yashop\common\models\Country`.
 */
class CountrySearch extends Country
{
    public function rules()
    {
        return [
            [['id', 'is_active', 'is_main', 'sort_order'], 'integer'],
            [['code', 'ru', 'en'], 'safe'],
        ];
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = Country::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => Yii::$app->params['pageSize'],
            ],
            'sort' => [
                'defaultOrder' => ['sort_order'=>SORT_ASC]
            ]
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'is_active' => $this->is_active,
            'is_main' => $this->is_main,
            'sort_order' => $this->sort_order,
        ]);

        $query->andFilterWhere(['like', 'code', $this->code])
            ->andFilterWhere(['like', 'ru', $this->ru])
            ->andFilterWhere(['like', 'en', $this->en]);

        return $dataProvider;
    }
}
