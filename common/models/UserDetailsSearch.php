<?php

namespace common\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\UserDetails;

/**
 * UserDetailsSearch represents the model behind the search form of `common\models\UserDetails`.
 */
class UserDetailsSearch extends UserDetails {

    public $branchName;
    public $companyName;

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
//            [['id', 'user_id', 'city', 'job_title', 'travel_preference', 'ssn', 'work_authorization', 'created_at', 'updated_at'], 'integer'],
            [['first_name', 'last_name', 'mobile_no', 'street_no', 'street_address', 'apt', 'zip_code', 'profile_pic', 'current_position', 'speciality', 'work experience', 'job_looking_from', 'work_authorization_comment', 'license_suspended', 'professional_liability', 'branchName', 'companyName'], 'safe'],
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
        $query = UserDetails::find()->joinWith(['user', 'branch']);


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
            'user_id' => $this->user_id,
            'city' => $this->city,
            'job_title' => $this->job_title,
            'job_looking_from' => $this->job_looking_from,
            'travel_preference' => $this->travel_preference,
            'ssn' => $this->ssn,
            'work_authorization' => $this->work_authorization,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'first_name', $this->first_name])
                ->andFilterWhere(['like', 'last_name', $this->last_name])
                ->andFilterWhere(['like', 'mobile_no', $this->mobile_no])
                ->andFilterWhere(['like', 'street_no', $this->street_no])
                ->andFilterWhere(['like', 'street_address', $this->street_address])
                ->andFilterWhere(['like', 'apt', $this->apt])
                ->andFilterWhere(['like', 'zip_code', $this->zip_code])
                ->andFilterWhere(['like', 'profile_pic', $this->profile_pic])
                ->andFilterWhere(['like', 'current_position', $this->current_position])
                ->andFilterWhere(['like', 'speciality', $this->speciality])
//            ->andFilterWhere(['like', 'work experience', $this->work experience])
                ->andFilterWhere(['like', 'work_authorization_comment', $this->work_authorization_comment])
                ->andFilterWhere(['like', 'license_suspended', $this->license_suspended])
                ->andFilterWhere(['like', 'professional_liability', $this->professional_liability]);

        return $dataProvider;
    }

    public function searchStaff($params) {
        $query = UserDetails::find()->joinWith(['user', 'branch'])->where(['company_branch.id' => \Yii::$app->user->identity->branch_id]);


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
            'user_id' => $this->user_id,
            'city' => $this->city,
            'job_title' => $this->job_title,
            'job_looking_from' => $this->job_looking_from,
            'travel_preference' => $this->travel_preference,
            'ssn' => $this->ssn,
            'work_authorization' => $this->work_authorization,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'first_name', $this->first_name])
                ->andFilterWhere(['like', 'last_name', $this->last_name])
                ->andFilterWhere(['like', 'mobile_no', $this->mobile_no])
                ->andFilterWhere(['like', 'street_no', $this->street_no])
                ->andFilterWhere(['like', 'street_address', $this->street_address])
                ->andFilterWhere(['like', 'apt', $this->apt])
                ->andFilterWhere(['like', 'zip_code', $this->zip_code])
                ->andFilterWhere(['like', 'profile_pic', $this->profile_pic])
                ->andFilterWhere(['like', 'current_position', $this->current_position])
                ->andFilterWhere(['like', 'speciality', $this->speciality])
//            ->andFilterWhere(['like', 'work experience', $this->work experience])
                ->andFilterWhere(['like', 'work_authorization_comment', $this->work_authorization_comment])
                ->andFilterWhere(['like', 'license_suspended', $this->license_suspended])
                ->andFilterWhere(['like', 'professional_liability', $this->professional_liability]);

        return $dataProvider;
    }

    public function searchPending($params = []) {
        $query = UserDetails::find()->joinWith(['user', 'branch'])->where(['user.status' => User::STATUS_PENDING]);

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
            'user_id' => $this->user_id,
            'city' => $this->city,
            'job_title' => $this->job_title,
            'job_looking_from' => $this->job_looking_from,
            'travel_preference' => $this->travel_preference,
            'ssn' => $this->ssn,
            'work_authorization' => $this->work_authorization,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'first_name', $this->first_name])
                ->andFilterWhere(['like', 'last_name', $this->last_name])
                ->andFilterWhere(['like', 'mobile_no', $this->mobile_no])
                ->andFilterWhere(['like', 'street_no', $this->street_no])
                ->andFilterWhere(['like', 'street_address', $this->street_address])
                ->andFilterWhere(['like', 'apt', $this->apt])
                ->andFilterWhere(['like', 'zip_code', $this->zip_code])
                ->andFilterWhere(['like', 'profile_pic', $this->profile_pic])
                ->andFilterWhere(['like', 'current_position', $this->current_position])
                ->andFilterWhere(['like', 'speciality', $this->speciality])
//            ->andFilterWhere(['like', 'work experience', $this->work experience])
                ->andFilterWhere(['like', 'work_authorization_comment', $this->work_authorization_comment])
                ->andFilterWhere(['like', 'license_suspended', $this->license_suspended])
                ->andFilterWhere(['like', 'professional_liability', $this->professional_liability]);

        return $dataProvider;
    }

    public function searchApproved($params = []) {
        $query = UserDetails::find()->joinWith(['user', 'branch'])->where(['user.status' => User::STATUS_APPROVED]);

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
            'user_id' => $this->user_id,
            'city' => $this->city,
            'job_title' => $this->job_title,
            'job_looking_from' => $this->job_looking_from,
            'travel_preference' => $this->travel_preference,
            'ssn' => $this->ssn,
            'work_authorization' => $this->work_authorization,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'first_name', $this->first_name])
                ->andFilterWhere(['like', 'last_name', $this->last_name])
                ->andFilterWhere(['like', 'mobile_no', $this->mobile_no])
                ->andFilterWhere(['like', 'street_no', $this->street_no])
                ->andFilterWhere(['like', 'street_address', $this->street_address])
                ->andFilterWhere(['like', 'apt', $this->apt])
                ->andFilterWhere(['like', 'zip_code', $this->zip_code])
                ->andFilterWhere(['like', 'profile_pic', $this->profile_pic])
                ->andFilterWhere(['like', 'current_position', $this->current_position])
                ->andFilterWhere(['like', 'speciality', $this->speciality])
//            ->andFilterWhere(['like', 'work experience', $this->work experience])
                ->andFilterWhere(['like', 'work_authorization_comment', $this->work_authorization_comment])
                ->andFilterWhere(['like', 'license_suspended', $this->license_suspended])
                ->andFilterWhere(['like', 'professional_liability', $this->professional_liability]);

        return $dataProvider;
    }

    public function searchRejected($params = []) {
        $query = UserDetails::find()->joinWith(['user', 'branch'])->where(['user.status' => User::STATUS_REJECTED]);

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
            'user_id' => $this->user_id,
            'city' => $this->city,
            'job_title' => $this->job_title,
            'job_looking_from' => $this->job_looking_from,
            'travel_preference' => $this->travel_preference,
            'ssn' => $this->ssn,
            'work_authorization' => $this->work_authorization,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'first_name', $this->first_name])
                ->andFilterWhere(['like', 'last_name', $this->last_name])
                ->andFilterWhere(['like', 'mobile_no', $this->mobile_no])
                ->andFilterWhere(['like', 'street_no', $this->street_no])
                ->andFilterWhere(['like', 'street_address', $this->street_address])
                ->andFilterWhere(['like', 'apt', $this->apt])
                ->andFilterWhere(['like', 'zip_code', $this->zip_code])
                ->andFilterWhere(['like', 'profile_pic', $this->profile_pic])
                ->andFilterWhere(['like', 'current_position', $this->current_position])
                ->andFilterWhere(['like', 'speciality', $this->speciality])
//            ->andFilterWhere(['like', 'work experience', $this->work experience])
                ->andFilterWhere(['like', 'work_authorization_comment', $this->work_authorization_comment])
                ->andFilterWhere(['like', 'license_suspended', $this->license_suspended])
                ->andFilterWhere(['like', 'professional_liability', $this->professional_liability]);

        return $dataProvider;
    }

}
