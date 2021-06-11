<?php

namespace common\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Advertisement;

/**
 * AdvertisementSearch represents the model behind the search form of `common\models\Advertisement`.
 */
class AdvertisementSearch extends Advertisement {

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['id', 'location_display'], 'integer'],
            [['name', 'description', 'link_url', 'icon', 'location_name', 'is_active', 'active_from', 'active_to', 'created_at', 'updated_at'], 'safe'],
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
        $query = Advertisement::find();

        // add conditions that should always apply here

        if ((\Yii::$app->request->get("sort") == Null)) {
            $query->orderBy(['created_at' => SORT_DESC]);
        }
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
            'location_display' => $this->location_display,
          
            'active_from' => isset($this->active_from) && !empty($this->active_from) ? date('Y-m-d', strtotime($this->active_from)) : $this->active_from,
            'active_to' => isset($this->active_to) && !empty($this->active_to) ? date('Y-m-d', strtotime($this->active_to)) : $this->active_to,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'is_active' => $this->is_active,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
                ->andFilterWhere(['like', 'description', $this->description])
                ->andFilterWhere(['like', 'link_url', $this->link_url])
                ->andFilterWhere(['like', 'icon', $this->icon])
                ->andFilterWhere(['like', 'location_name', $this->location_name]);
//                ->andFilterWhere(['like', 'is_active', $this->is_active]);

        return $dataProvider;
    }

}
