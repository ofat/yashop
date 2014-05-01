<?php
/**
 * @author Vitaliy Ofat <ofatv22@gmail.com>
 */
namespace admin\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Currency;

/**
 * CurrencySearch represents the model behind the search form about `common\models\Currency`.
 */
class CurrencySearch extends Currency
{
    public function rules()
    {
        return [
            [['id', 'is_active', 'is_default','is_main', 'sort_order'], 'integer'],
            ['rate', 'number'],
            [['name', 'mask'], 'safe'],
        ];
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * @param $params
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Currency::find();

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
            'is_default' => $this->is_default,
            'is_main' => $this->is_main,
            'sort_order' => $this->sort_order,
            'rate' => $this->rate
        ]);

        $query->andFilterWhere(['like', 'mask', $this->mask])
            ->andFilterWhere(['like', 'name', $this->name]);

        return $dataProvider;
    }
}
