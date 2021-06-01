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
 * @property int $created_at
 * @property int $updated_at
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
//            ['path','required','message' => 'please select document!'],
            [['document_type', 'user_id','created_at','updated_at'], 'integer'],
            [['path'], 'string', 'max' => 255],
//            [['path'], 'file', 'skipOnEmpty' => false, 'extensions'=>['docx', 'pdf', 'doc'], 'checkExtensionByMimeType'=>false]
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
