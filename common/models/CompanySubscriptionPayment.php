<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "company_subscription_payment".
 *
 * @property int $id
 * @property int $subscription_id
 * @property int $amount
 * @property int $payment_type
 * @property int|null $lead_id
 * @property int $created_at
 * @property int $updated_at
 */
class CompanySubscriptionPayment extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'company_subscription_payment';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['subscription_id', 'amount', 'payment_type', 'created_at', 'updated_at'], 'required'],
            [['subscription_id', 'amount', 'payment_type', 'lead_id', 'created_at', 'updated_at'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'subscription_id' => 'Subscription ID',
            'amount' => 'Amount',
            'payment_type' => 'Payment Type',
            'lead_id' => 'Lead ID',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}
