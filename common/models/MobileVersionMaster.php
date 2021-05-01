<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "mobile_version_master".
 *
 * @property int $id
 * @property string $device_type
 * @property string $version
 * @property int $force_update 1:yes 0:no
 * @property string $created_at
 * @property string $updated_at
 */
class MobileVersionMaster extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'mobile_version_master';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['device_type', 'version'], 'required'],
            [['force_update'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['device_type', 'version'], 'string', 'max' => 250],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'device_type' => 'Device Type',
            'version' => 'Version',
            'force_update' => 'Force Update',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}
