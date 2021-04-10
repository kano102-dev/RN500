<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "discipline".
 *
 * @property int $id
 * @property string $name
 * @property int $created_at
 * @property int $updated_at
 *
 * @property LeadDiscipline[] $leadDisciplines
 */
class Discipline extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'discipline';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'created_at', 'updated_at'], 'required'],
            [['created_at', 'updated_at'], 'integer'],
            [['name'], 'string', 'max' => 500],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * Gets query for [[LeadDisciplines]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getLeadDisciplines()
    {
        return $this->hasMany(LeadDiscipline::className(), ['discipline_id' => 'id']);
    }
}
