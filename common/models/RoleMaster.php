<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "role_master".
 *
 * @property int $id
 * @property string $role_name
 * @property int $created_at
 * @property int $updated_at
 */
class RoleMaster extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'role_master';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['role_name', 'created_at', 'updated_at'], 'required'],
            [['created_at', 'updated_at'], 'integer'],
            [['role_name'], 'string', 'max' => 250],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'role_name' => 'Role Name',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}
