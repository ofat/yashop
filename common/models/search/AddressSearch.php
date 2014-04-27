<?php

namespace common\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\user\Address;

/**
 * AddressSearch represents the model behind the search form about `common\models\user\Address`.
 */
class AddressSearch extends Address
{
    public function rules()
    {
        return [
            [['id', 'user_id', 'country_id', 'used_count', 'is_default', 'is_hidden'], 'integer'],
            [['full_name', 'zipcode', 'region', 'city', 'street', 'building', 'apartment', 'phone'], 'safe'],
        ];
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = Address::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => Yii::$app->params['pageSize'],
            ],
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'user_id' => $this->user_id,
            'country_id' => $this->country_id,
            'used_count' => $this->used_count,
            'is_default' => $this->is_default,
            'is_hidden' => $this->is_hidden,
        ]);

        $query->andFilterWhere(['like', 'full_name', $this->full_name])
            ->andFilterWhere(['like', 'zipcode', $this->zipcode])
            ->andFilterWhere(['like', 'region', $this->region])
            ->andFilterWhere(['like', 'city', $this->city])
            ->andFilterWhere(['like', 'street', $this->street])
            ->andFilterWhere(['like', 'building', $this->building])
            ->andFilterWhere(['like', 'apartment', $this->apartment])
            ->andFilterWhere(['like', 'phone', $this->phone]);

        return $dataProvider;
    }
}
