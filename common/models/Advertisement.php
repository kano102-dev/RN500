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
 * @property string $location_name
 * @property string $is_active 0- Inactive, 1- Active	
 * @property int $location_display
 * @property string|null $active_from
 * @property string|null $active_to
 * @property string|null $created_at
 * @property string|null $updated_at
 */
class Advertisement extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'advertisement';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['description', 'is_active','video_link','link_url'], 'string'],
            [['is_active', 'location_display','vendor_id'], 'required'],
            [['location_display','file_type'], 'integer'],
            [['description','name'], 'match', 'pattern' => '/^[a-zA-Z0-9 ]*$/', 'message' => 'Only number and alphabets allowed for {attribute} field'],
//            [['link_url','video_link'], 'match', 'pattern' => '/[-a-zA-Z0-9@:%._\+~#=]{1,256}\.[a-zA-Z0-9()]{1,6}\b([-a-zA-Z0-9()@:%_\+.~#?&//=]*)?/', 'message' => 'Please Enter Valid Url For {attribute} field'],
            [['icon'], 'required', "message" => "Please select {attribute}.", 'when' => function($model) {
                    return $model->file_type != 2;
                }, 'whenClient' => "function (attribute, value) {
                return ($('#type_1').is(':checked'));
            }"],
            [['video_link'], 'required', "message" => "Please Enter {attribute}.", 'when' => function($model) {
                    return $model->file_type != 1;
                }, 'whenClient' => "function (attribute, value) {
                return ($('#type_2').is(':checked'));
            }"],            
            [['active_from', 'active_to', 'created_at', 'updated_at','created_by', 'updated_by','vendor_id'], 'safe'],
            [['name', 'icon'], 'string', 'max' => 255],
            [['location_name'], 'string', 'max' => 100],
            [['icon'], 'file', 'extensions'=>['jpg','png','jpeg'], 'checkExtensionByMimeType'=>false,"wrongExtension" => "File type is not compatible. Please upload a PNG or JPG file."],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'vendor_id' => 'Vendor',
            'name' => 'Name',
            'description' => 'Description',
            'link_url' => 'Link Url',
            'icon' => 'Icon',
            'location_name' => 'Location Name',
            'is_active' => 'Is Active',
            'location_display' => 'Location Display',
            'active_from' => 'Active From',
            'active_to' => 'Active To',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}
