<?php

namespace common\models;

use Yii;
use common\CommonFunction;

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
class Documents extends \yii\db\ActiveRecord {

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'documents';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
                [['document_type', 'user_id'], 'required'],
                ['path', 'required', 'on' => 'create'],
//            ['path','required','message' => 'please select document!','on' => 'create'],
            [['document_type', 'user_id', 'created_at', 'updated_at'], 'integer'],
                [['path'], 'string', 'max' => 255],
                ['path', 'file', 'extensions' => ['png', 'jpg', 'jpeg', 'docx', 'pdf'], 'maxSize' => 1024 * 1024 * 2],
//            [['path'], 'file', 'skipOnEmpty' => false, 'extensions'=>['docx', 'pdf', 'doc'], 'checkExtensionByMimeType'=>false]
        ];
    }

    public function scenarios() {
        $scenarios = parent::scenarios();
        $scenarios['create'] = ['document_type', 'path', 'user_id', 'created_at', 'updated_at',];
        return $scenarios;
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'document_type' => 'Document Type',
            'path' => 'Path',
            'user_id' => 'User ID',
        ];
    }

    public function getDecumentTypeName() {
        return $name = (isset(Yii::$app->params['DOCUMENT_TYPE'][$this->document_type]) && Yii::$app->params['DOCUMENT_TYPE'][$this->document_type] != '') ? Yii::$app->params['DOCUMENT_TYPE'][$this->document_type] : '';
    }

    public function getDocumentUrl() {
        $url = '';
        if ($this->path != '' && file_exists(CommonFunction::getDocumentBasePath() . "/" . $this->path)) {
            $url = \Yii::$app->urlManager->createAbsoluteUrl((['/uploads/user-details/document/' . $this->path]));
        }
        return $url;
    }

}
