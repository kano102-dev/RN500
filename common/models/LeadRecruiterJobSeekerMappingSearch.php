<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\LeadRecruiterJobSeekerMapping;
use common\CommonFunction;

/**
 * LeadRecruiterJobSeekerMappingSearch represents the model behind the search form of `common\models\LeadRecruiterJobSeekerMapping`.
 */
class LeadRecruiterJobSeekerMappingSearch extends LeadRecruiterJobSeekerMapping {

    public $leadTitleWithRef;
    public $jobSeekerName;
    public $loggedUserBranchId;
    public $cityName;
    public $rec_joining_date_selected;

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
                [['branch_id', 'lead_id', 'job_seeker_id', 'rec_comment', 'rec_status ', 'updated_at', 'updated_by', 'rec_joining_date', 'employer_comment', 'employer_status', 'leadTitleWithRef', 'cityName', 'jobSeekerName','rec_joining_date_selected'], 'safe'],
                [['leadTitleWithRef', 'cityName', 'jobSeekerName','rec_joining_date_selected'], 'trim']
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios() {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

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


        $query = LeadRecruiterJobSeekerMapping::find()->alias("lrjm")
                ->joinWith(['lead lead', 'jobSeeker jobseeker'])
                ->leftJoin("cities", "cities.id = lead.city")
                ->leftJoin("user_details ud", "jobseeker.id = ud.user_id");

        if (CommonFunction::isRecruiter()) {
            $query->andWhere(['AND', ['lrjm.rec_status' => parent::STATUS_PENDING], ['lrjm.employer_status' => parent::STATUS_PENDING]]);
            $query->andWhere(['lrjm.branch_id' => $this->loggedUserBranchId]);
        }

        if (CommonFunction::isEmployer()) {
            $query->andWhere(['AND', ['lrjm.rec_status' => parent::STATUS_APPROVED], ['lrjm.employer_status' => parent::STATUS_PENDING]]);
            $query->andWhere(['lead.branch_id' => $this->loggedUserBranchId]);
        }

        // add conditions that should always apply here
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => ['defaultOrder' => ['updated_at' => SORT_DESC]]
        ]);


        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        if ($this->leadTitleWithRef) {
            $query->andWhere(['OR',
                    ['like', 'lead.title', $this->leadTitleWithRef],
                    ['like', 'lead.reference_no', $this->leadTitleWithRef],
                    ['like', new \yii\db\Expression('CONCAT(lead.title, " ( ", lead.reference_no, " )")'), $this->leadTitleWithRef]
            ]);
        }

        if ($this->cityName) {
            $query->andWhere(['like', 'cities.city', $this->cityName]);
        }

        if ($this->rec_joining_date) {
            $query->andWhere(['like', 'lrjm.rec_joining_date', date('Y-m-d', strtotime($this->rec_joining_date))]);
        }

        if ($this->jobSeekerName) {
            $query->andWhere(['like', 'CONCAT(ud.first_name, " ", ud.last_name)', $this->jobSeekerName]);
        }

        return $dataProvider;
    }

    public function searchLeadsReceivedInprogress($params) {

        $query = LeadRecruiterJobSeekerMapping::find()->alias("lrjm")
                ->joinWith(['lead lead', 'jobSeeker jobseeker'])
                ->leftJoin("cities", "cities.id = lead.city")
                ->leftJoin("user_details ud", "jobseeker.id = ud.user_id");


        if (CommonFunction::isRecruiter()) {
            $query->andWhere(['AND', ['lrjm.rec_status' => parent::STATUS_APPROVED], ['lrjm.employer_status' => parent::STATUS_PENDING]]);
            $query->andWhere(['lrjm.branch_id' => $this->loggedUserBranchId]);
        }

        if (CommonFunction::isEmployer()) {
            $query->andWhere(['AND', ['lrjm.rec_status' => parent::STATUS_PENDING], ['lrjm.employer_status' => parent::STATUS_PENDING]]);
            $query->andWhere(['lead.branch_id' => $this->loggedUserBranchId]);
        }




        // add conditions that should always apply here
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => ['defaultOrder' => ['updated_at' => SORT_DESC]]
        ]);


        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        if ($this->leadTitleWithRef) {
            $query->andWhere(['OR',
                    ['like', 'lead.title', $this->leadTitleWithRef],
                    ['like', 'lead.reference_no', $this->leadTitleWithRef],
                    ['like', new \yii\db\Expression('CONCAT(lead.title, " ( ", lead.reference_no, " )")'), $this->leadTitleWithRef]
            ]);
        }

        if ($this->cityName) {
            $query->andWhere(['like', 'cities.city', $this->cityName]);
        }

        if ($this->rec_joining_date) {
            $query->andWhere(['like', 'lrjm.rec_joining_date', date('Y-m-d', strtotime($this->rec_joining_date))]);
        }

        if ($this->jobSeekerName) {
            $query->andWhere(['like', 'CONCAT(ud.first_name, " ", ud.last_name)', $this->jobSeekerName]);
        }


        return $dataProvider;
    }

    public function searchLeadsReceivedSelected($params) {

        $query = LeadRecruiterJobSeekerMapping::find()->alias("lrjm")
                ->joinWith(['lead lead', 'jobSeeker jobseeker'])
                ->leftJoin("cities", "cities.id = lead.city")
                ->leftJoin("user_details ud", "jobseeker.id = ud.user_id");


        if (CommonFunction::isRecruiter()) {
            $query->andWhere(['OR', ['AND', ['lrjm.rec_status' => parent::STATUS_APPROVED], ['lrjm.employer_status' => parent::STATUS_APPROVED]], ['lrjm.employer_status' => parent::STATUS_APPROVED]]);
            $query->andWhere(['lrjm.branch_id' => $this->loggedUserBranchId]);
        }

        if (CommonFunction::isEmployer()) {
            $query->andWhere(['OR', ['AND', ['lrjm.rec_status' => parent::STATUS_APPROVED], ['lrjm.employer_status' => parent::STATUS_APPROVED]], ['lrjm.employer_status' => parent::STATUS_APPROVED]]);
            $query->andWhere(['lead.branch_id' => $this->loggedUserBranchId]);
        }


        // add conditions that should always apply here
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => ['defaultOrder' => ['updated_at' => SORT_DESC]]
        ]);


        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }


        if ($this->leadTitleWithRef) {
            $query->andWhere(['OR',
                    ['like', 'lead.title', $this->leadTitleWithRef],
                    ['like', 'lead.reference_no', $this->leadTitleWithRef],
                    ['like', new \yii\db\Expression('CONCAT(lead.title, " ( ", lead.reference_no, " )")'), $this->leadTitleWithRef]
            ]);
        }

        if ($this->cityName) {
            $query->andWhere(['like', 'cities.city', $this->cityName]);
        }

        if ($this->rec_joining_date || $this->rec_joining_date_selected) {
            $joiningDate =  ($this->rec_joining_date) ? $this->rec_joining_date  : $this->rec_joining_date_selected;
            $query->andWhere(['like', 'lrjm.rec_joining_date', date('Y-m-d', strtotime($joiningDate))]);
        }

        if ($this->jobSeekerName) {
            $query->andWhere(['like', 'CONCAT(ud.first_name, " ", ud.last_name)', $this->jobSeekerName]);
        }


        return $dataProvider;
    }

    public function searchLeadsReceivedRejected($params) {

        $query = LeadRecruiterJobSeekerMapping::find()->alias("lrjm")
                ->joinWith(['lead lead', 'jobSeeker jobseeker'])
                ->leftJoin("cities", "cities.id = lead.city")
                ->leftJoin("user_details ud", "jobseeker.id = ud.user_id");




        if (CommonFunction::isRecruiter()) {
            $query->andWhere(['OR', ['lrjm.rec_status' => parent::STATUS_REJECTED], ['lrjm.employer_status' => parent::STATUS_REJECTED]]);
            $query->andWhere(['lrjm.branch_id' => $this->loggedUserBranchId]);
        }

        if (CommonFunction::isEmployer()) {
            $query->andWhere(['OR', ['lrjm.rec_status' => parent::STATUS_REJECTED], ['lrjm.employer_status' => parent::STATUS_REJECTED]]);
            $query->andWhere(['lead.branch_id' => $this->loggedUserBranchId]);
        }


        // add conditions that should always apply here
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => ['defaultOrder' => ['updated_at' => SORT_DESC]]
        ]);


        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        if ($this->leadTitleWithRef) {
            $query->andWhere(['OR',
                    ['like', 'lead.title', $this->leadTitleWithRef],
                    ['like', 'lead.reference_no', $this->leadTitleWithRef],
                    ['like', new \yii\db\Expression('CONCAT(lead.title, " ( ", lead.reference_no, " )")'), $this->leadTitleWithRef]
            ]);
        }

        if ($this->cityName) {
            $query->andWhere(['like', 'cities.city', $this->cityName]);
        }

        if ($this->rec_joining_date) {
            $query->andWhere(['like', 'lrjm.rec_joining_date', date('Y-m-d', strtotime($this->rec_joining_date))]);
        }

        if ($this->jobSeekerName) {
            $query->andWhere(['like', 'CONCAT(ud.first_name, " ", ud.last_name)', $this->jobSeekerName]);
        }



        return $dataProvider;
    }

}
