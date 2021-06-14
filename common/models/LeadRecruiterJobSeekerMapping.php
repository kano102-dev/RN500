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
 * @property string|null $rec_comment
 * @property int $rec_status 0:pending, 1:Approve
 * @property int $updated_at
 * @property int $updated_by
 * @property string|null $rec_joining_date
 * @property string|null $employer_comment
 * @property int $employer_status 0:pending, 1:Approve
 *
 * @property CompanyBranch $branch
 * @property LeadMaster $lead
 */
class LeadRecruiterJobSeekerMapping extends \yii\db\ActiveRecord {

    const STATUS_PENDING = 0;
    const STATUS_APPROVED = 1;
    const STATUS_REJECTED = 2;
    const STATUS_INPROGRESS = 3; // ADD FOR CONCEPTUALIZATION ONLY, WE DIDN'T STORE IN DB

    public $rating;
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
                [['branch_id', 'lead_id', 'job_seeker_id', 'rec_status', 'updated_at', 'updated_by'], 'integer'],
                [['rec_comment', 'employer_comment'], 'string', 'max' => 500],
                [['branch_id'], 'exist', 'skipOnError' => true, 'targetClass' => CompanyBranch::className(), 'targetAttribute' => ['branch_id' => 'id']],
                [['lead_id'], 'exist', 'skipOnError' => true, 'targetClass' => LeadMaster::className(), 'targetAttribute' => ['lead_id' => 'id']],
                [['branch_id', 'lead_id', 'job_seeker_id', 'rec_comment', 'rec_status ', 'updated_at', 'updated_by', 'rec_joining_date', 'employer_comment', 'employer_status'], 'safe'],
                [['rec_comment', 'employer_comment'], 'trim'],
            // SCENARIO BASE VALIDATION
            [['rec_joining_date'], 'required', 'on' => 'rec_approve'],
                [['rec_comment'], 'required', 'on' => 'rec_reject'],
                [['employer_comment'], 'required', 'on' => 'employer_reject'],
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
            'rec_comment' => 'Comment',
            'rec_status' => 'Status',
            'rec_joining_date' => 'Joining Date',
            'employer_comment' => 'Comment',
            'employer_status' => 'Status',
            'updated_at' => 'Updated At',
            'updated_by' => 'Updated By',
            'leadTitleWithRef' => 'Lead',
            'jobSeekerName' => 'Job Seeker',
            'cityName' => 'City',
            'recruiterComapnyWithBranch' => 'Recruiter Comapny',
            'statusText' => 'Status',
        ];
    }

    public function scenarios() {
        $scenarios = parent::scenarios();
        $scenarios['rec_approve'] = ['rec_joining_date', 'rec_comment'];
        $scenarios['rec_reject'] = ['rec_comment'];
        $scenarios['employer_approve'] = ['employer_comment'];
        $scenarios['employer_reject'] = ['employer_comment'];
        return $scenarios;
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

    public static function checkAlreadyApplied($lead_id, $branch_id, $loggedInUserId) {
        return LeadRecruiterJobSeekerMapping::find()->where(['lead_id' => $lead_id, 'branch_id' => $branch_id, 'job_seeker_id' => $loggedInUserId])->one() !== null;
    }

    public function getLeadTitleWithRef() {
        $title = '';
        if (isset($this->lead) && !empty($this->lead)) {
            $lead = $this->lead;
            $title = $lead->title . " (" . $lead->reference_no . ") ";
        }
        return $title;
    }

    public function getJobSeekerName() {
        $name = '';
        if (isset($this->jobSeeker) && !empty($this->jobSeeker)) {
            $user = $this->jobSeeker;
            $name = $user->getFullName();
        }
        return $name;
    }

    public function getCityName() {
        $name = '';
        if (isset($this->lead) && isset($this->lead->cities)) {
            $name = $this->lead->cities->city;
        }
        return $name;
    }

    public function getRecruiterComapnyWithBranch() {
        $recruiterCompanyName = '';
        if (isset($this->branch) && !empty($this->branch)) {
            $branch = $this->branch;
            $company = (isset($branch->company) && !empty($branch->company)) ? $branch->company : '';
            $recruiterCompanyName = $company->company_name . " ( " . $branch->branch_name . " )";
        }
        return $recruiterCompanyName;
    }

    public function getOverAllStatus() {
        $status = self::STATUS_INPROGRESS;
        if ($this->rec_status == self::STATUS_PENDING && $this->employer_status == self::STATUS_PENDING) {
            $status = self::STATUS_PENDING;
        } else if ($this->rec_status == self::STATUS_APPROVED && $this->employer_status == self::STATUS_APPROVED) {
            $status = self::STATUS_APPROVED;
        } else if ($this->rec_status == self::STATUS_REJECTED || $this->employer_status == self::STATUS_REJECTED) {
            $status = self::STATUS_REJECTED;
        }
        return $status;
    }

    public static function getStatusList() {
        return [self::STATUS_PENDING => 'Pending', self::STATUS_APPROVED => 'Approved', self::STATUS_REJECTED => 'Rejected', self::STATUS_INPROGRESS => 'In Progress'];
    }

    public function getStatusText() {
        $status = $this->getOverAllStatus();
        $getStatusList = self::getStatusList();
        return (isset($getStatusList[$status]) && $getStatusList[$status]) ? $getStatusList[$status] : '';
    }
    
//     public static function getRating() {
//        return 0;
//    }

    /**
     *  SENDS MAIL TO RECRUITER BRANCH
     *  0: Issue in mail server
     *  1: Mail sent successfully
     *  2: Branch has doesn't any email registered / branch doesn't exists
     *  3: something went wrong
     */
    public function sendMailToBranch() {
        $status = '2';
        $message = 'Branch not mapped';
        try {
            if ($this->branch) {
                $branchEMail = (isset($this->branch->email) && $this->branch->email != '') ? $this->branch->email : '';
                if ($branchEMail != '') {
                    $lead = $this->lead;
                    $job_seeker = $this->jobSeeker;
                    $urlToSend = Yii::$app->urlManagerFrontend->createAbsoluteUrl(['/profile/user-summary', 'ref' => $job_seeker->details->unique_id]);

                    $status = Yii::$app->mailer->compose('lead-recruiter-new-job-application-by-jobseeker', ['lead' => $lead, 'job_seeker' => $job_seeker, 'urlToSend' => $urlToSend])
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
            return ['status' => (string) $status, 'message' => $message];
        }
    }

    /**
     *  SENDS MAIL TO JOB-SEEKER  ABOUT TO RECRUITER APPROVED LEAD
     *  0: Issue in mail server
     *  1: Mail sent successfully
     *  3: issue Mail sending
     */
    public function sendMailToJobSeekerAboutRecruiterApproval() {
        $status = '3';
        $message = 'Something went wrong.';
        try {
            $branchName = (isset($this->branch->branch_name) && $this->branch->branch_name != '') ? $this->branch->branch_name : '';
            $companyName = (isset($this->branch->company->company_name) && $this->branch->company->company_name != '') ? $this->branch->company->company_name : '';
            $lead = $this->lead;
            $job_seeker = $this->jobSeeker;
            $status = Yii::$app->mailer->compose('lead-job-seeker-approval-by-recruiter', ['lead' => $lead, 'job_seeker' => $job_seeker, 'branchName' => $companyName . ' (' . $branchName . ')'])
                    ->setFrom([Yii::$app->params['senderEmail'] => Yii::$app->params['senderName']])
                    ->setTo($job_seeker->email)
                    ->setSubject('Appliaction approved by ' . $companyName . ' (' . $branchName . ')')
                    ->send();
            $message = ($status) ? 'Mail sent successfully.' : 'Issue in mail server.';
        } catch (\Exception $ex) {
            $status = '3';
            $message = 'Something went wrong.';
        } finally {
            return ['status' => (string) $status, 'message' => $message];
        }
    }

    /**
     *  SENDS MAIL TO JOB-SEEKER ABOUT TO RECRUITER REJECTED LEAD
     *  0: Issue in mail server
     *  1: Mail sent successfully
     *  3: issue Mail sending
     */
    public function sendMailToJobSeekerAboutRecruiterRejection() {
        $status = '3';
        $message = 'Something went wrong.';
        try {
            $branchName = (isset($this->branch->branch_name) && $this->branch->branch_name != '') ? $this->branch->branch_name : '';
            $companyName = (isset($this->branch->company->company_name) && $this->branch->company->company_name != '') ? $this->branch->company->company_name : '';
            $lead = $this->lead;
            $job_seeker = $this->jobSeeker;
            $status = Yii::$app->mailer->compose('lead-job-seeker-reject-by-recruiter', ['lead' => $lead, 'job_seeker' => $job_seeker, 'branchName' => $companyName . ' (' . $branchName . ')'])
                    ->setFrom([Yii::$app->params['senderEmail'] => Yii::$app->params['senderName']])
                    ->setTo($job_seeker->email)
                    ->setSubject('Appliaction rejected by ' . $companyName . ' (' . $branchName . ')')
                    ->send();
            $message = ($status) ? 'Mail sent successfully.' : 'Issue in mail server.';
        } catch (\Exception $ex) {
            $status = '3';
            $message = 'Something went wrong.';
        } finally {
            return ['status' => (string) $status, 'message' => $message];
        }
    }

    /**
     *  SENDS MAIL TO EMPLOYER ABOUT TO RECRUITER APPROVED HAS APPROVED LEAD NOW IT'S YOUR TURN
     *  0: Issue in mail server
     *  1: Mail sent successfully
     *  3: issue Mail sending
     */
    public function sendMailToEmployerAboutRecruiterApproval() {
        $status = '3';
        $message = 'Something went wrong.';
        try {
            $job_seeker = $this->jobSeeker;
            $lead = $this->lead;
            $leadPostedBranch = (isset($lead->branch)) ? $lead->branch : [];
            if (!empty($leadPostedBranch)) {
                $branchName = (isset($leadPostedBranch->branch_name) && $leadPostedBranch->branch_name != '') ? $leadPostedBranch->branch_name : '';
                $companyName = (isset($leadPostedBranch->company->company_name) && $leadPostedBranch->company->company_name != '') ? $leadPostedBranch->company->company_name : '';
                $status = Yii::$app->mailer->compose('lead-employer-by-recruiter-approval', ['lead' => $lead, 'job_seeker' => $job_seeker, 'branchName' => $branchName])
                        ->setFrom([Yii::$app->params['senderEmail'] => Yii::$app->params['senderName']])
                        ->setTo($leadPostedBranch->email)
                        ->setSubject('New appliaction Received for approval in ' . $companyName . ' (' . $branchName . ')')
                        ->send();
                $message = ($status) ? 'Mail sent successfully.' : 'Issue in mail server.';
            }
        } catch (\Exception $ex) {
            $status = '3';
            $message = 'Something went wrong.';
        } finally {
            return ['status' => (string) $status, 'message' => $message];
        }
    }

    /**
     *  SENDS MAIL TO RECRUITER BRANCH ABOUT EMPLOYER APPROVED THE LEAD
     *  0: Issue in mail server
     *  1: Mail sent successfully
     *  3: Something went wrong
     */
    public function sendMailToRecruiterAboutApproveLeadByEmployer() {
        $status = '3';
        $message = 'Something went wrong.';
        try {
            $lead = $this->lead;
            $job_seeker = $this->jobSeeker;
            $branchEMail = (isset($this->branch->email) && $this->branch->email != '') ? $this->branch->email : '';
            $leadPostedBranch = (isset($lead->branch)) ? $lead->branch : [];
            if (!empty($leadPostedBranch)) {
                $leadPostedBranchName = (isset($leadPostedBranch->branch_name) && $leadPostedBranch->branch_name != '') ? $leadPostedBranch->branch_name : '';
                $leadPostedCompanyName = (isset($leadPostedBranch->company->company_name) && $leadPostedBranch->company->company_name != '') ? $leadPostedBranch->company->company_name : '';
                $status = Yii::$app->mailer->compose('lead-recruiter-notify-approved-by-employer', ['lead' => $lead, 'job_seeker' => $job_seeker])
                        ->setFrom([\Yii::$app->params['senderEmail'] => \Yii::$app->params['senderName']])
                        ->setTo($branchEMail)
                        ->setSubject('Lead approved by employer ' . $leadPostedCompanyName . ' (' . $leadPostedBranchName . ')')
                        ->send();
                $message = ($status) ? 'Mail sent successfully.' : 'Issue in mail server.';
            }
        } catch (\Exception $ex) {
            $status = '3';
            $message = 'Something went wrong.';
        } finally {
            return ['status' => (string) $status, 'message' => $message];
        }
    }

    /**
     *  SENDS MAIL TO RECRUITER BRANCH ABOUT EMPLOYER REJECTED THE LEAD
     *  0: Issue in mail server
     *  1: Mail sent successfully
     *  3: Something went wrong
     */
    public function sendMailToRecruiterAboutRejectLeadByEmployer() {
        $status = '3';
        $message = 'Something went wrong.';
        try {
            $lead = $this->lead;
            $job_seeker = $this->jobSeeker;
            $branchEMail = (isset($this->branch->email) && $this->branch->email != '') ? $this->branch->email : '';
            $leadPostedBranch = (isset($lead->branch)) ? $lead->branch : [];
            if (!empty($leadPostedBranch)) {
                $leadPostedBranchName = (isset($leadPostedBranch->branch_name) && $leadPostedBranch->branch_name != '') ? $leadPostedBranch->branch_name : '';
                $leadPostedCompanyName = (isset($leadPostedBranch->company->company_name) && $leadPostedBranch->company->company_name != '') ? $leadPostedBranch->company->company_name : '';
                $status = Yii::$app->mailer->compose('lead-recruiter-notify-rejected-by-employer', ['lead' => $lead, 'job_seeker' => $job_seeker])
                        ->setFrom([\Yii::$app->params['senderEmail'] => \Yii::$app->params['senderName']])
                        ->setTo($branchEMail)
                        ->setSubject('Lead rejected by employer ' . $leadPostedCompanyName . ' (' . $leadPostedBranchName . ')')
                        ->send();
                $message = ($status) ? 'Mail sent successfully.' : 'Issue in mail server.';
            }
        } catch (\Exception $ex) {
            $status = '3';
            $message = 'Something went wrong.';
        } finally {
            return ['status' => (string) $status, 'message' => $message];
        }
    }

}
