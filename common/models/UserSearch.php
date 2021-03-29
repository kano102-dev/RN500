<?php

namespace common\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\User;

/**
 * UserSearch represents the model behind the search form of `common\models\User`.
 */
class UserSearch extends User {

    public $fullName;

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
                [['id', 'status', 'role_id', 'branch_id', 'type', 'is_master_admin', 'password_reset_token'], 'integer'],
                [['email', 'password', 'original_password', 'auth_key', 'fullName'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios() {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params) {
        $query = User::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'status' => $this->status,
            'role_id' => $this->role_id,
            'branch_id' => $this->branch_id,
            'type' => $this->type,
            'is_master_admin' => $this->is_master_admin,
            'password_reset_token' => $this->password_reset_token,
        ]);

        $query->andFilterWhere(['like', 'email', $this->email])
                ->andFilterWhere(['like', 'password', $this->password])
                ->andFilterWhere(['like', 'original_password', $this->original_password])
                ->andFilterWhere(['like', 'auth_key', $this->auth_key]);

        return $dataProvider;
    }

}
