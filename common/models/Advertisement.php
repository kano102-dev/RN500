<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "advertisement".
 *
 * @property int $id
 * @property string|null $name
 * @property string|null $description
 * @property string|null $link_url
 * @property string|null $icon
 * @property int $location
 * @property string $is_active 0- Inactive, 1- Active	
 * @property string|null $active_from
 * @property string|null $active_to
 * @property string|null $created_at
 * @property string|null $updated_at
 */
class Advertisement extends \yii\db\ActiveRecord {

    
    const FILE_TYPE_IMAGE = 1;
    const FILE_TYPE_YOUTUBE_LINK = 2;
    
    public static function tableName() {
        return 'advertisement';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['description', 'is_active', 'video_link', 'link_url'], 'string'],
            [['is_active', 'vendor_id', 'name', 'link_url', 'active_from','location'], 'required'],
            [['file_type'], 'integer'],
            [['link_url'], 'url'],
            [['name'], 'match', 'pattern' => '/^[a-zA-Z0-9 ]*$/', 'message' => 'Only number and alphabets allowed for {attribute} field'],
            [['description'], 'match', 'pattern' => '/^[a-zA-Z0-9 ,.]*$/', 'message' => 'Only number and alphabets allowed for {attribute} field'],
//            [['link_url','video_link'], 'match', 'pattern' => '/[-a-zA-Z0-9@:%._\+~#=]{1,256}\.[a-zA-Z0-9()]{1,6}\b([-a-zA-Z0-9()@:%_\+.~#?&//=]*)?/', 'message' => 'Please Enter Valid Url For {attribute} field'],
            [['icon'], 'required', "message" => "Please select {attribute}.", 'when' => function($model) {
                    return $model->file_type != 2 && empty($model->icon);
                }, 'whenClient' => "function (attribute, value) {
                return ($('#type_1').is(':checked') && $('#image').val() == '');
            }"],
            [['video_link'], 'required', "message" => "Please Enter {attribute}.", 'when' => function($model) {
                    return $model->file_type != 1;
                }, 'whenClient' => "function (attribute, value) {
                return ($('#type_2').is(':checked'));
            }"],
            [['name', 'link_url', 'video_link', 'active_from', 'description', 'active_to', 'created_at', 'updated_at', 'created_by', 'updated_by', 'vendor_id'], 'safe'],
            [['name', 'icon'], 'string', 'max' => 255],
            [['location'], 'integer'],
            [['icon'], 'file', 'extensions' => ['jpg', 'png', 'jpeg'], 'checkExtensionByMimeType' => false, "wrongExtension" => "File type is not compatible. Please upload a PNG or JPG file."],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'vendor_id' => 'Vendor',
            'name' => 'Name',
            'description' => 'Description',
            'link_url' => 'Link Url',
            'icon' => 'Icon',
            'location' => 'City',
            'is_active' => 'Is Active',
            'active_from' => 'Active From',
            'active_to' => 'Active To',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    public function getCity() {
        return $this->hasOne(Cities::className(), ['id' => 'location']);
    }

}
