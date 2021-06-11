<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\LeadRecruiterJobSeekerMapping;

/**
 * LeadRecruiterJobSeekerMappingSearch represents the model behind the search form of `common\models\LeadRecruiterJobSeekerMapping`.
 */
class LeadRecruiterJobSeekerMappingSearch extends LeadRecruiterJobSeekerMapping {

    public $leadTitleWithRef;
    public $jobSeekerName;
    public $loggedUserBranchId;

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
                [['branch_id', 'lead_id', 'job_seeker_id', 'rec_comment', 'rec_status ', 'updated_at', 'updated_by', 'rec_joining_date', 'employer_comment', 'employer_status'], 'safe']
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
        $query = LeadRecruiterJobSeekerMapping::find();

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
            'lead_id' => $this->lead_id,
            'job_seeker_id' => $this->job_seeker_id,
            'status' => $this->status,
            'updated_at' => $this->updated_at,
            'updated_by' => $this->updated_by,
        ]);

        $query->andFilterWhere(['like', 'comment', $this->comment]);

        return $dataProvider;
    }

    public function searchLeadsReceivedPending($params) {
        

        $query = LeadRecruiterJobSeekerMapping::find()->alias("lrjm")->joinWith(['lead lead', 'jobSeeker jobseeker']);

        $query->andWhere(['AND', ['lrjm.rec_status' => parent::STATUS_PENDING], ['lrjm.employer_status' => parent::STATUS_PENDING]]);
        $query->andWhere(['lrjm.branch_id' => $this->loggedUserBranchId]);
        // add conditions that should always apply here
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => ['defaultOrder' => ['updated_at' => SORT_DESC]]
        ]);


        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        return $dataProvider;
    }
    
    public function searchLeadsReceivedInprogress($params) {

        $query = LeadRecruiterJobSeekerMapping::find()->alias("lrjm")->joinWith(['lead lead', 'jobSeeker jobseeker']);

        $query->andWhere(['AND', ['lrjm.rec_status' => parent::STATUS_APPROVED], ['lrjm.employer_status' => parent::STATUS_PENDING]]);
        
        $query->andWhere(['lrjm.branch_id' => $this->loggedUserBranchId]);
        // add conditions that should always apply here
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => ['defaultOrder' => ['updated_at' => SORT_DESC]]
        ]);


        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        return $dataProvider;
    }

    public function searchLeadsReceivedSelected($params) {

        $query = LeadRecruiterJobSeekerMapping::find()->alias("lrjm")->joinWith(['lead lead', 'jobSeeker jobseeker']);
        $query->andWhere(['OR',['AND', ['lrjm.rec_status' => parent::STATUS_APPROVED], ['lrjm.employer_status' => parent::STATUS_APPROVED]],['lrjm.employer_status' => parent::STATUS_APPROVED]]);
        $query->andWhere(['lrjm.branch_id' => $this->loggedUserBranchId]);
        // add conditions that should always apply here
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => ['defaultOrder' => ['updated_at' => SORT_DESC]]
        ]);


        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        return $dataProvider;
    }

    public function searchLeadsReceivedRejected($params) {

        $query = LeadRecruiterJobSeekerMapping::find()->alias("lrjm")->joinWith(['lead lead', 'jobSeeker jobseeker']);

        $query->andWhere(['OR', ['lrjm.rec_status' => parent::STATUS_REJECTED], ['lrjm.employer_status' => parent::STATUS_REJECTED]]);
        $query->andWhere(['lrjm.branch_id' => $this->loggedUserBranchId]);
        // add conditions that should always apply here
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => ['defaultOrder' => ['updated_at' => SORT_DESC]]
        ]);


        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        return $dataProvider;
    }

}
