<?php
/**
 * @author Vitaliy Ofat <ofatv22@gmail.com>
 */

namespace yashop\common\models\search;

use yashop\common\models\favorite\FavoriteItem;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use Yii;

class FavoriteSearch extends FavoriteItem
{
    public function rules()
    {
        return [
            [['id', 'user_id', 'item_id'], 'integer']
        ];
    }

    public function scenarios()
    {
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = FavoriteItem::find()->with('item', 'item.description');

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
            'item_id' => $this->item_id
        ]);

        return $dataProvider;
    }
}