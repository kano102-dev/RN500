<?php

namespace common\models;

use Yii;
use common\CommonFunction;

/**
 * This is the model class for table "referral_master".
 *
 * @property int $id
 * @property int $lead_id
 * @property string $from_name
 * @property string $from_email
 * @property string|null $description
 * @property string $to_name
 * @property string $to_email
 * @property string $created_at
 *
 * @property LeadMaster $lead
 */
class ReferralMaster extends \yii\db\ActiveRecord {

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'referral_master';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
                [['lead_id', 'from_name', 'from_email', 'to_name', 'to_email'], 'required'],
                [['lead_id'], 'integer'],
                [['created_at'], 'safe'],
                [['from_name', 'from_email', 'to_name', 'to_email'], 'string', 'max' => 255],
                [['description'], 'string', 'max' => 1000],
                [['lead_id'], 'exist', 'skipOnError' => true, 'targetClass' => LeadMaster::className(), 'targetAttribute' => ['lead_id' => 'id']],
                [['from_name', 'from_email', 'description', 'to_name', 'to_email', 'created_at',], 'trim'],
                [['from_name', 'from_email', 'description', 'to_name', 'to_email', 'created_at',], 'safe'],
                [['from_email', 'to_email'], 'email'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'lead_id' => 'Lead',
            'from_name' => 'Sender Name',
            'from_email' => 'Sender Email',
            'description' => 'Description',
            'to_name' => 'Recipient Name',
            'to_email' => 'Recipient Email',
            'created_at' => 'Created At',
        ];
    }

    /**
     * Gets query for [[Lead]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getLead() {
        return $this->hasOne(LeadMaster::className(), ['id' => 'lead_id']);
    }

    public function getLeadTitleWithRef() {
        $title = '';
        if (isset($this->lead) && !empty($this->lead)) {
            $lead = $this->lead;
            $title = $lead->title . " (" . $lead->reference_no . ") ";
        }
        return $title;
    }

    public function sendReferralMail() {

        try {
            $referralLink = Yii::$app->urlManager->createAbsoluteUrl(['browse-jobs/view', 'id' => (isset($this->lead->reference_no) && $this->lead->reference_no != '') ? (string) $this->lead->reference_no : '']);
            $status = Yii::$app->mailer->compose('lead-referral', ['model' => $this, 'referralLink' => $referralLink])
                    ->setFrom([$this->from_email => $this->from_name])
                    ->setTo($this->to_email)
                    ->setSubject('Invited to apply the Job')
                    ->send();
            if ($status) {
                $this->created_at = date('Y-m-d h:i:s', CommonFunction::currentTimestamp());
                $this->save(false);
            }
            return $status;
        } catch (\Exception $ex) {
            return false;
        }
    }

}