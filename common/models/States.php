<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "states".
 *
 * @property int $id
 * @property string $state
 * @property string $state_code
 * @property int $country_id
 */
class States extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'states';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['state', 'state_code', 'country_id'], 'required'],
            [['country_id'], 'integer'],
            [['state'], 'string', 'max' => 22],
            [['state_code'], 'string', 'max' => 2],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'state' => 'State',
            'state_code' => 'State Code',
            'country_id' => 'Country ID',
        ];
    }
}
