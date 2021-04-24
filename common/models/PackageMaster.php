<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "package_master".
 *
 * @property int $id
 * @property string $title
 * @property int $is_default 1:yes 0:no
 * @property int $status
 */
class PackageMaster extends \yii\db\ActiveRecord {

    const PAY_AS_A_GO = 1;
    const STATUS_ACTIVE = 1;
    const STATUS_INACTIVE = 2;

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'package_master';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['title', 'price','status'], 'required'],
            [['created_at', 'updated_at', 'created_by', 'updated_by'], 'safe'],
            [['is_default', 'status'], 'integer'],
            [['title'], 'string', 'max' => 250],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'price' => 'Price',
            'is_default' => '1:yes 0:no',
            'status' => 'Status',
        ];
    }

}
