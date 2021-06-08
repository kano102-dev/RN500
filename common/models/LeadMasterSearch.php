<?php

namespace common\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\LeadMaster;

/**
 * LeadMasterSearch represents the model behind the search form of `common\models\LeadMaster`.
 */
class LeadMasterSearch extends LeadMaster {

    public $company_name;
    public $branch_name;

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
                [['id', 'branch_id', 'payment_type', 'job_type', 'shift', 'recruiter_commission', 'recruiter_commission_type', 'recruiter_commission_mode', 'price', 'status', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
                [['title', 'reference_no', 'description', 'start_date', 'end_date', 'comment'], 'safe'],
                [['jobseeker_payment'], 'number'],
                [['company_name', 'branch_name'], 'safe'],
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
        $query = LeadMaster::find();

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
            'branch_id' => $this->branch_id,
            'jobseeker_payment' => $this->jobseeker_payment,
            'payment_type' => $this->payment_type,
            'job_type' => $this->job_type,
            'shift' => $this->shift,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'recruiter_commission' => $this->recruiter_commission,
            'recruiter_commission_type' => $this->recruiter_commission_type,
            'recruiter_commission_mode' => $this->recruiter_commission_mode,
            'price' => $this->price,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
                ->andFilterWhere(['like', 'reference_no', $this->reference_no])
                ->andFilterWhere(['like', 'description', $this->description])
                ->andFilterWhere(['like', 'comment', $this->comment]);

        return $dataProvider;
    }

    public function searchPending($params = []) {
        $query = LeadMaster::find()->where(['status' => LeadMaster::STATUS_PENDING]);

        // add conditions that should always apply here
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }


        return $dataProvider;
    }

    public function searchApproved($params = []) {
        $query = LeadMaster::find()->where(['status' => LeadMaster::STATUS_APPROVED]);

        // add conditions that should always apply here
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }


        return $dataProvider;
    }

    public function searchJobApply($params) {
        $reference_no = isset($params['ref']) ? $params['ref'] : '';
//        echo "<pre/>";
//        print_r($params);
//        exit;

        $query = CompanyBranch::find()->alias('branch')->select("branch.*, subscribed_companies.company_name")
                ->innerJoin("( 
                                SELECT sub.company_id, company.company_name, lead.reference_no FROM company_subscription_payment sub_pay
                                LEFT JOIN company_subscription sub ON sub.id = sub_pay.subscription_id
                                LEFT JOIN company_master company ON company.id = sub.company_id
                                LEFT JOIN lead_master lead ON lead.id = sub_pay.lead_id
                                WHERE lead.reference_no='$reference_no' AND sub_pay.status=1 AND sub.status=1 AND company.status = 1  AND company.type = " . User::TYPE_RECRUITER . " AND is_suspend = 0 
                                GROUP BY sub.company_id
                            ) as subscribed_companies", "subscribed_companies.company_id = branch.company_id");

//        
        // add conditions that should always apply here
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }
        if ($this->branch_name) {
            $query->andWhere(['LIKE', 'branch.branch_name', $this->branch_name]);
        }

        if ($this->company_name) {
            $query->andWhere(['LIKE', 'subscribed_companies.company_name', $this->company_name]);
        }

        return $dataProvider;
    }

}
