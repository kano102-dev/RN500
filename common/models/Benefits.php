<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "benefits".
 *
 * @property int $id
 * @property string $name
 * @property int $created_at
 * @property int $updated_at
 *
 * @property LeadBenefit[] $leadBenefits
 */
class Benefits extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'benefits';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'created_at', 'updated_at'], 'required'],
            [['created_at', 'updated_at','created_by', 'updated_by'], 'integer'],
            [['name'], 'string', 'max' => 500],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * Gets query for [[LeadBenefits]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getLeadBenefits()
    {
        return $this->hasMany(LeadBenefit::className(), ['benefit_id' => 'id']);
    }
}
