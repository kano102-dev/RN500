<?php

namespace common\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\UserDetails;
use common\CommonFunction;

/**
 * UserDetailsSearch represents the model behind the search form of `common\models\UserDetails`.
 */
class UserDetailsSearch extends UserDetails {

    public $branchName;
    public $companyNames;
    public $email;
    public $role_id;
    public $user_type;

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
//            [['id', 'user_id', 'city', 'job_title', 'travel_preference', 'ssn', 'work_authorization', 'created_at', 'updated_at'], 'integer'],
            [['user_type', 'unique_id', 'city', 'role_id', 'email', 'first_name', 'last_name', 'mobile_no', 'street_no', 'street_address', 'apt', 'zip_code', 'profile_pic', 'current_position', 'speciality', 'work experience', 'job_looking_from', 'work_authorization_comment', 'license_suspended', 'professional_liability', 'branchName', 'companyNames'], 'safe'],
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
        $query = UserDetails::find()->joinWith(['user', 'branch', 'cityRef'])
                ->innerJoin('company_master', 'company_master.id=company_branch.company_id')
                ->where(['user.status' => User::STATUS_APPROVED, 'user.type' => User::TYPE_RECRUITER, 'user.is_owner' => 1, 'company_branch.is_default' => 1]);


        // add conditions that should always apply here
        if ((\Yii::$app->request->get("sort") == Null)) {
            $query->orderBy(['created_at' => SORT_DESC]);
        }
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $dataProvider->setSort([
            'attributes' => [
                'id',
                'first_name' => [
                    'asc' => ['first_name' => SORT_ASC],
                    'desc' => ['first_name' => SORT_DESC],
                    'default' => SORT_ASC
                ],
                'last_name' => [
                    'asc' => ['last_name' => SORT_ASC],
                    'desc' => ['last_name' => SORT_DESC],
                    'default' => SORT_ASC
                ],
                'companyNames' => [
                    'asc' => ['company_master.company_name' => SORT_ASC],
                    'desc' => ['company_master.company_name' => SORT_DESC],
                    'default' => SORT_ASC
                ],
                'branchName' => [
                    'asc' => ['company_branch.branch_name' => SORT_ASC],
                    'desc' => ['company_branch.branch_name' => SORT_DESC],
                    'default' => SORT_ASC
                ],
                'email' => [
                    'asc' => ['user.email' => SORT_ASC],
                    'desc' => ['user.email' => SORT_DESC],
                    'default' => SORT_ASC
                ],
                'city' => [
                    'asc' => ['cities.city' => SORT_ASC],
                    'desc' => ['cities.city' => SORT_DESC],
                    'default' => SORT_ASC
                ],
            ]
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
                ->andFilterWhere(['like', 'company_master.company_name', $this->companyNames])
                ->andFilterWhere(['like', 'company_branch.branch_name', $this->branchName])
                ->andFilterWhere(['like', 'user.email', $this->email])
                ->andFilterWhere(['like', 'cities.city', $this->city])
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

    public function searchEmployer($params) {
        $query = UserDetails::find()->joinWith(['user', 'branch', 'cityRef'])->innerJoin('company_master', 'company_master.id=company_branch.company_id')->where(['user.status' => User::STATUS_APPROVED, 'user.type' => User::TYPE_EMPLOYER, 'user.is_owner' => 1, 'company_branch.is_default' => 1]);

        // add conditions that should always apply here
        if ((\Yii::$app->request->get("sort") == Null)) {
            $query->orderBy(['created_at' => SORT_DESC]);
        }
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $dataProvider->setSort([
            'attributes' => [
                'id',
                'first_name' => [
                    'asc' => ['first_name' => SORT_ASC],
                    'desc' => ['first_name' => SORT_DESC],
                    'default' => SORT_ASC
                ],
                'last_name' => [
                    'asc' => ['last_name' => SORT_ASC],
                    'desc' => ['last_name' => SORT_DESC],
                    'default' => SORT_ASC
                ],
                'companyNames' => [
                    'asc' => ['company_master.company_name' => SORT_ASC],
                    'desc' => ['company_master.company_name' => SORT_DESC],
                    'default' => SORT_ASC
                ],
                'branchName' => [
                    'asc' => ['company_branch.branch_name' => SORT_ASC],
                    'desc' => ['company_branch.branch_name' => SORT_DESC],
                    'default' => SORT_ASC
                ],
                'email' => [
                    'asc' => ['user.email' => SORT_ASC],
                    'desc' => ['user.email' => SORT_DESC],
                    'default' => SORT_ASC
                ],
                'city' => [
                    'asc' => ['cities.city' => SORT_ASC],
                    'desc' => ['cities.city' => SORT_DESC],
                    'default' => SORT_ASC
                ],
            ]
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
                ->andFilterWhere(['like', 'company_master.company_name', $this->companyNames])
                ->andFilterWhere(['like', 'company_branch.branch_name', $this->branchName])
                ->andFilterWhere(['like', 'user.email', $this->email])
                ->andFilterWhere(['like', 'cities.city', $this->city])
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
        $subQuery = User::find()->select('user.id')->joinWith(['branch'])->where(['company_branch.is_default' => 1])->andWhere(['user.is_owner' => 1]);
        $query = UserDetails::find()->joinWith(['user', 'branch', 'cityRef'])
                ->leftJoin('role_master', 'user.role_id=role_master.id')->innerJoin('company_master', 'company_master.id=company_branch.company_id')
                ->where(['user.status' => User::STATUS_APPROVED, 'user.is_suspend' => 0])
                ->andWhere(['IN', 'user.type', [User::TYPE_RECRUITER, User::TYPE_EMPLOYER]]);
        $query->andWhere(['not in', 'user.id', $subQuery]);
        if (!CommonFunction::isMasterAdmin(\Yii::$app->user->identity->id)) {
            if (CommonFunction::isHoAdmin(\Yii::$app->user->identity->id)) {
                $query->andWhere(['company_master.id' => \Yii::$app->user->identity->branch->company_id]);
            } else {
                $query->andWhere(['company_branch.id' => \Yii::$app->user->identity->branch_id]);
            }
        }

        // add conditions that should always apply here
        if ((\Yii::$app->request->get("sort") == Null)) {
            $query->orderBy(['created_at' => SORT_DESC]);
        }
//        echo $query->createCommand()->rawSql;exit;
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);


        $dataProvider->setSort([
            'attributes' => [
                'id',
                'first_name' => [
                    'asc' => ['first_name' => SORT_ASC],
                    'desc' => ['first_name' => SORT_DESC],
                    'default' => SORT_ASC
                ],
                'last_name' => [
                    'asc' => ['last_name' => SORT_ASC],
                    'desc' => ['last_name' => SORT_DESC],
                    'default' => SORT_ASC
                ],
                'companyNames' => [
                    'asc' => ['company_master.company_name' => SORT_ASC],
                    'desc' => ['company_master.company_name' => SORT_DESC],
                    'default' => SORT_ASC
                ],
                'branchName' => [
                    'asc' => ['company_branch.branch_name' => SORT_ASC],
                    'desc' => ['company_branch.branch_name' => SORT_DESC],
                    'default' => SORT_ASC
                ],
                'role_id' => [
                    'asc' => ['role_master.role_name' => SORT_ASC],
                    'desc' => ['role_master.role_name' => SORT_DESC],
                    'default' => SORT_ASC
                ],
                'email' => [
                    'asc' => ['user.email' => SORT_ASC],
                    'desc' => ['user.email' => SORT_DESC],
                    'default' => SORT_ASC
                ],
                'city' => [
                    'asc' => ['cities.city' => SORT_ASC],
                    'desc' => ['cities.city' => SORT_DESC],
                    'default' => SORT_ASC
                ],
                'user_type' => [
                    'asc' => ['user.type' => SORT_ASC],
                    'desc' => ['user.type' => SORT_DESC],
                    'default' => SORT_ASC
                ],
            ]
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
            'user.type' => $this->user_type,
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
                ->andFilterWhere(['like', 'user.email', $this->email])
                ->andFilterWhere(['like', 'company_master.company_name', $this->companyNames])
                ->andFilterWhere(['like', 'company_branch.branch_name', $this->branchName])
                ->andFilterWhere(['like', 'role_master.role_name', $this->role_id])
                ->andFilterWhere(['like', 'cities.city', $this->city])
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
        $query = UserDetails::find()->joinWith(['user', 'branch'])->where(['user.status' => User::STATUS_APPROVED, 'company_branch.is_default' => 1]);

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
        $query = UserDetails::find()->joinWith(['user', 'branch'])->where(['user.status' => User::STATUS_REJECTED, 'company_branch.is_default' => 1]);

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

    public function searchJobseeker($params) {
        $query = UserDetails::find()->joinWith(['user', 'cityRef'])->where(['user.status' => User::STATUS_APPROVED, 'user.type' => User::TYPE_JOB_SEEKER, 'user.is_suspend' => 0]);
        // add conditions that should always apply here
        if ((\Yii::$app->request->get("sort") == Null)) {
            $query->orderBy(['created_at' => SORT_DESC]);
        }
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        $dataProvider->setSort([
            'attributes' => [
                'id',
                'unique_id',
                'first_name' => [
                    'asc' => ['first_name' => SORT_ASC],
                    'desc' => ['first_name' => SORT_DESC],
                    'default' => SORT_ASC
                ],
                'last_name' => [
                    'asc' => ['last_name' => SORT_ASC],
                    'desc' => ['last_name' => SORT_DESC],
                    'default' => SORT_ASC
                ],
                'email' => [
                    'asc' => ['user.email' => SORT_ASC],
                    'desc' => ['user.email' => SORT_DESC],
                    'default' => SORT_ASC
                ],
                'city' => [
                    'asc' => ['cities.city' => SORT_ASC],
                    'desc' => ['cities.city' => SORT_DESC],
                    'default' => SORT_ASC
                ],
            ]
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
                ->andFilterWhere(['like', 'unique_id', $this->unique_id])
                ->andFilterWhere(['like', 'company_master.company_name', $this->companyNames])
                ->andFilterWhere(['like', 'company_branch.branch_name', $this->branchName])
                ->andFilterWhere(['like', 'user.email', $this->email])
                ->andFilterWhere(['like', 'cities.city', $this->city])
                ->andFilterWhere(['like', 'mobile_no', $this->mobile_no])
                ->andFilterWhere(['like', 'street_no', $this->street_no])
                ->andFilterWhere(['like', 'street_address', $this->street_address])
                ->andFilterWhere(['like', 'apt', $this->apt])
                ->andFilterWhere(['like', 'zip_code', $this->zip_code])
                ->andFilterWhere(['like', 'profile_pic', $this->profile_pic])
                ->andFilterWhere(['like', 'current_position', $this->current_position])
                ->andFilterWhere(['like', 'speciality', $this->speciality])
                ->andFilterWhere(['like', 'work_authorization_comment', $this->work_authorization_comment])
                ->andFilterWhere(['like', 'license_suspended', $this->license_suspended])
                ->andFilterWhere(['like', 'professional_liability', $this->professional_liability]);

        return $dataProvider;
    }

}
