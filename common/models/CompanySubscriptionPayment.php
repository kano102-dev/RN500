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
    const STATUS_PENDING=0;
    const STATUS_SUCCESS=1;
    const STATUS_Fail=2;
    
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
            [['subscription_id', 'amount', 'created_at', 'updated_at'], 'required'],
            [['subscription_id', 'amount', 'lead_id', 'created_at', 'updated_at'], 'integer'],
            [['payment_response','customer_transaction_id','status'], 'safe'],
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
            'status' => 'Status',
            'payment_response' => 'Payment Response',
            'customer_transaction_id' => 'Transaction ID',
            'lead_id' => 'Lead ID',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}
