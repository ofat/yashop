<?php
/**
 * @author Vitaliy Ofat <ofatv22@gmail.com>
 */

namespace yashop\admin\models;

use yashop\common\models\item\Item;
use yashop\common\models\item\ItemDescription;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use Yii;

/**
 * Class ItemSearch
 * @package yashop\admin\models
 */
class ItemSearch extends Item
{
    public function rules()
    {
        return [
            [['id', 'category_id'], 'integer'],
            [['description.name', 'url', 'is_active'], 'safe'],
        ];
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function attributes()
    {
        // add related fields to searchable attributes
        return array_merge(parent::attributes(), ['description.name']);
    }

    public function search($params)
    {
        $query = Item::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => Yii::$app->params['pageSize'],
            ]
        ]);

        $query->joinWith(['description' => function($query) { $query->from(['description' => ItemDescription::tableName()]); }]);

        $dataProvider->sort->attributes['description.name'] = [
            'asc' => ['description.name' => SORT_ASC],
            'desc' => ['description.name' => SORT_DESC],
        ];

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'category_id' => $this->category_id
        ]);

        $query->andFilterWhere(['like', 'description.name', $this->getAttribute('description.name')]);

        return $dataProvider;
    }
}