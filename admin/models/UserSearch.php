<?php

namespace admin\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\User;

/**
 * UserSearch represents the model behind the search form about `common\models\User`.
 */
class UserSearch extends User
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return User::tableName();
    }

    /**
     * Add relative attributes
     * @return array Attributes
     */
    public function attributes()
    {
        return array_merge(parent::attributes(), [
            'role.item_name'
        ]);
    }

    public function rules()
    {
        return [
            [['id', 'status' ], 'integer'],
            [['username', 'email', 'role.item_name'], 'safe'],
        ];
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = User::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => Yii::$app->params['pageSize'],
            ],
            'sort' => [
                'defaultOrder' => ['id'=>SORT_DESC]
            ]
        ]);

        $query->joinWith(['role' => function($query) { $query->from(['role' => 'auth_assignment']); }]);

        $dataProvider->sort->attributes['role.item_name'] = [
            'asc' => ['role.item_name' => SORT_ASC],
            'desc' => ['role.item_name' => SORT_DESC],
        ];

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'status' => $this->status,
            'role.item_name' => $this->getAttribute('role.item_name'),
        ]);

        $query->andFilterWhere(['like', 'username', $this->username])
            ->andFilterWhere(['like', 'email', $this->email]);

        return $dataProvider;
    }
}
