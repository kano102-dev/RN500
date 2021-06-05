<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "lead_recruiter_job_seeker_mapping".
 *
 * @property int $id
 * @property int $branch_id
 * @property int $lead_id
 * @property int $job_seeker_id
 * @property string|null $comment
 * @property int $status 0:pending, 1:Approve
 * @property int $updated_at
 * @property int $updated_by
 *
 * @property CompanyBranch $branch
 * @property LeadMaster $lead
 */
class LeadRecruiterJobSeekerMapping extends \yii\db\ActiveRecord {

    const STATUS_PENDING = 0;
    const STATUS_APPROVED = 1;

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'lead_recruiter_job_seeker_mapping';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
                [['branch_id', 'lead_id', 'job_seeker_id', 'updated_at', 'updated_by'], 'required'],
                [['branch_id', 'lead_id', 'job_seeker_id', 'status', 'updated_at', 'updated_by'], 'integer'],
                [['comment'], 'string', 'max' => 500],
                [['branch_id'], 'exist', 'skipOnError' => true, 'targetClass' => CompanyBranch::className(), 'targetAttribute' => ['branch_id' => 'id']],
                [['lead_id'], 'exist', 'skipOnError' => true, 'targetClass' => LeadMaster::className(), 'targetAttribute' => ['lead_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'branch_id' => 'Branch ID',
            'lead_id' => 'Lead ID',
            'job_seeker_id' => 'Job Seeker ID',
            'comment' => 'Comment',
            'status' => 'Status',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
        ];
    }

    /**
     * Gets query for [[Branch]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getBranch() {
        return $this->hasOne(CompanyBranch::className(), ['id' => 'branch_id']);
    }

    /**
     * Gets query for [[Lead]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getLead() {
        return $this->hasOne(LeadMaster::className(), ['id' => 'lead_id']);
    }

    public function getJobSeeker() {
        return $this->hasOne(User::className(), ['id' => 'job_seeker_id']);
    }

    /**
     *  0: Issue in mail server
     *  1: Mail sent successfully
     *  2: Branch has doesn't any email registered / branch doesn't exists
     *  3: issue Mail sending
     */
    public function sendMailToBranch() {
        $status = '0';
        $message = 'Branch not mapped';
        try {
            if ($this->branch) {
                $branchEMail = (isset($this->branch->email) && $this->branch->email != '') ? $this->branch->email : '';
                if ($branchEMail != '') {
                    $lead = $this->lead;
                    $job_seeker = $this->jobSeeker;
                    $urlToSend = Yii::$app->urlManagerFrontend->createAbsoluteUrl(['/profile/user-summary', 'ref' => $job_seeker->details->unique_id]);
                    
                    $status = Yii::$app->mailer->compose('recruite-new-job-application', ['lead' => $lead, 'job_seeker' => $job_seeker,'urlToSend'=>$urlToSend])
                            ->setFrom([\Yii::$app->params['senderEmail'] => \Yii::$app->params['senderName']])
                            ->setTo($branchEMail)
                            ->setSubject('New Job Appliaction')
                            ->send();
                    $message = ($status) ? 'Mail sent successfully.' : 'Issue in mail server.';
               
                } else {
                    $status = '2';
                    $message = "Branch hasn't any email ID registered.";
                }
            } else {
                $status = '2';
                $message = "No such branch is mapped.";
            }
        } catch (\Exception $ex) {
            $status = '3';
            $message = 'Something went wrong.';
        } finally {
            return ['status' => $status, 'message' => $message];
        }
    }

}
