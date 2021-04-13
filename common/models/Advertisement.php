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
            [['description', 'is_active'], 'string'],
            [['location_name', 'is_active', 'location_display','vendor_id'], 'required'],
            [['location_display'], 'integer'],
            [['active_from', 'active_to', 'created_at', 'updated_at','created_by', 'updated_by','vendor_id'], 'safe'],
            [['name', 'icon'], 'string', 'max' => 255],
            [['link_url', 'location_name'], 'string', 'max' => 100],
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
