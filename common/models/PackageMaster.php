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
            [['title', 'status'], 'required'],
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
            'is_default' => '1:yes 0:no',
            'status' => 'Status',
        ];
    }

}
