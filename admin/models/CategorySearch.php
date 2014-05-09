<?php

namespace yashop\admin\models;

use yashop\common\models\category\Category;
use yashop\common\models\category\CategoryDescription;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * CategorySearch represents the model behind the search form about `yashop\common\models\Category`.
 */
class CategorySearch extends Category
{
    public function rules()
    {
        return [
            [['id', 'parent_id'], 'integer'],
            [['description.name', 'description.title', 'description.meta_desc', 'description.meta_keyword', 'url', 'is_active'], 'safe'],
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
        return array_merge(parent::attributes(), ['description.name', 'description.title', 'description.meta_desc', 'description.meta_keyword']);
    }

    public function search($params)
    {
        $query = Category::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => Yii::$app->params['pageSize'],
            ]
        ]);

        $query->joinWith(['description' => function($query) { $query->from(['description' => CategoryDescription::tableName()]); }]);

        $dataProvider->sort->attributes['description.name'] = [
            'asc' => ['description.name' => SORT_ASC],
            'desc' => ['description.name' => SORT_DESC],
        ];
        $dataProvider->sort->attributes['description.title'] = [
            'asc' => ['description.title' => SORT_ASC],
            'desc' => ['description.title' => SORT_DESC],
        ];
        $dataProvider->sort->attributes['description.meta_keyword'] = [
            'asc' => ['description.meta_keyword' => SORT_ASC],
            'desc' => ['description.meta_keyword' => SORT_DESC],
        ];
        $dataProvider->sort->attributes['description.meta_desc'] = [
            'asc' => ['description.meta_desc' => SORT_ASC],
            'desc' => ['description.meta_desc' => SORT_DESC],
        ];

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'parent_id' => $this->parent_id,
            'is_active' => $this->is_active
        ]);

        $query->andFilterWhere(['like', 'url', $this->url])
            ->andFilterWhere(['like', 'description.name', $this->getAttribute('description.name')])
            ->andFilterWhere(['like', 'description.title', $this->getAttribute('description.title')])
            ->andFilterWhere(['like', 'description.meta_keyword', $this->getAttribute('description.meta_keyword')])
            ->andFilterWhere(['like', 'description.meta_desc', $this->getAttribute('description.meta_desc')]);

        return $dataProvider;
    }
}
