<?php

namespace common\models;

use Yii;
use common\CommonFunction;

/**
 * This is the model class for table "lead_master".
 *
 * @property int $id
 * @property string $title
 * @property string $reference_no
 * @property string|null $description
 * @property int $jobseeker_payment salary
 * @property int $payment_type 1:hourly,2:weekly,3:monthly
 * @property int $job_type 1:part_time,2:permanante,3:travel,4:on call
 * @property int $shift 1:all 2:morning 3:evening 4:night 5:flatulate
 * @property int $start_date
 * @property int|null $end_date
 * @property int $recruiter_commission agancy commision
 * @property int $recruiter_commission_type 1:percentage 0: amount
 * @property int $recruiter_commission_mode 0:one time 1:monthly 2 Yearly
 * @property int|null $price admin or master admin decide lead price
 * @property int|null $status 0:pending 1:approve 2:reject
 * @property int $created_at
 * @property int $updated_at
 * @property int $created_by
 * @property int $updated_by
 * @property int $branch_id
 * @property string|null $comment
 */
class LeadMaster extends \yii\db\ActiveRecord {

    public $disciplines;
    public $benefits;
    public $specialies;

    const STATUS_PENDING = 0;
    const STATUS_APPROVED = 1;

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'lead_master';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['title', 'reference_no', 'jobseeker_payment', 'payment_type', 'job_type', 'shift', 'start_date', 'created_at', 'updated_at', 'created_by', 'updated_by', 'description', 'branch_id'], 'required'],
            [['description'], 'string'],
            [['payment_type', 'job_type', 'shift', 'recruiter_commission', 'recruiter_commission_type', 'recruiter_commission_mode', 'price', 'status', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['jobseeker_payment',], 'number'],
            [['title'], 'string', 'max' => 250],
            [['reference_no'], 'string', 'max' => 50],
            [['comment'], 'string', 'max' => 500],
            [['reference_no'], 'unique'],
            [['approved_at','branch_id', 'comment', 'disciplines', 'benefits', 'specialies', 'end_date', 'start_date'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'title' => 'Job Title',
            'reference_no' => 'Reference No',
            'description' => 'Description',
            'jobseeker_payment' => 'Salary',
            'payment_type' => 'Payment Type',
            'job_type' => 'Job Type',
            'shift' => 'Shift',
            'start_date' => 'Start Date',
            'end_date' => 'End Date',
            'recruiter_commission' => 'Recruiter Commission',
            'recruiter_commission_type' => 'Recruiter Commision Type',
            'recruiter_commission_mode' => 'Recruiter Commision Mode',
            'price' => 'Price',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
            'branch_id' => 'Branch',
            'comment' => 'Comment',
        ];
    }

    public function getUniqueReferenceNumber() {
        $code = CommonFunction::generateRandomString(15);
        $exits = self::find()->where(['reference_no' => $code])->one();
        if ($exits) {
            $this->getUniqueReferenceNumber();
        } else {
            return $code;
        }
    }

    public function getBenefits() {
        return $this->hasMany(LeadBenefit::className(), ['lead_id' => 'id']);
    }

    public function getDisciplines() {
        return $this->hasMany(LeadDiscipline::className(), ['lead_id' => 'id']);
    }

    public function getSpecialty() {
        return $this->hasMany(LeadSpeciality::className(), ['lead_id' => 'id']);
    }

    public function getBranch() {
        return $this->hasOne(CompanyBranch::className(), ['id' => 'branch_id']);
    }

}
