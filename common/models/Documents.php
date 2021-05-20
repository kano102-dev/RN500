<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "documents".
 *
 * @property int $id
 * @property int $document_type
 * @property string $path
 * @property int $user_id
 */
class Documents extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'documents';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['document_type','user_id'], 'required'],
            [['document_type', 'user_id'], 'integer'],
            [['path'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'document_type' => 'Document Type',
            'path' => 'Path',
            'user_id' => 'User ID',
        ];
    }
}