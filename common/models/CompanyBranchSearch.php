<?php

namespace common\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\CompanyBranch;
use common\CommonFunction;

/**
 * CompanyBranchSearch represents the model behind the search form of `backend\models\CompanyBranch`.
 */
class CompanyBranchSearch extends CompanyBranch {

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['id'], 'integer'],
            [['company_id', 'city', 'is_default', 'created_at', 'updated_at', 'branch_name', 'street_no', 'street_address', 'apt', 'zip_code'], 'safe'],
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
        $query = CompanyBranch::find()->joinWith(['company', 'cityRef'])->where(['company_master.status' => 1]);
        if (!CommonFunction::isMasterAdmin(\Yii::$app->user->identity->id)) {
            if (CommonFunction::isHoAdmin(\Yii::$app->user->identity->id)) {
                $query->andWhere(['company_id' => \Yii::$app->user->identity->branch->company_id]);
            } else {
                $query->andWhere(['company_branch.id' => \Yii::$app->user->identity->branch_id]);
            }
        }

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
            'is_default' => $this->is_default,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'branch_name', $this->branch_name])
                ->andFilterWhere(['like', 'street_no', $this->street_no])
                ->andFilterWhere(['like', 'street_address', $this->street_address])
                ->andFilterWhere(['like', 'apt', $this->apt])
                ->andFilterWhere(['like', 'company_master.company_name', $this->company_id])
                ->andFilterWhere(['like', 'cities.city', $this->city])
                ->andFilterWhere(['like', 'zip_code', $this->zip_code]);

        return $dataProvider;
    }

}
