<?php

namespace common\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\RoleMaster;
use common\CommonFunction;

/**
 * RoleMasterSearch represents the model behind the search form of `common\models\RoleMaster`.
 */
class RoleMasterSearch extends RoleMaster {

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['id'], 'integer'],
            [['created_at', 'updated_at', 'role_name', 'company_id'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios() {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params) {
        $query = RoleMaster::find()->joinWith('company');
        if (!CommonFunction::isMasterAdmin(\Yii::$app->user->identity->id)) {
            $query->where(['company_id' => \Yii::$app->user->identity->branch->company_id]);
        }

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // created_at FILTERING FROM TIMESTAMP    
        $created_at = $this->created_at;
        $updated_at = $this->updated_at;
        if (isset($created_at) && !empty($created_at)) {

            $date = \DateTime::createFromFormat('m-d-Y', $this->created_at);
            $date->setTime(0, 0, 0);

            // set lowest date value
            $unixDateStart = $date->getTimeStamp();

            // add 1 day and subtract 1 second
            $date->add(new \DateInterval('P1D'));
            $date->sub(new \DateInterval('PT1S'));

            // set highest date value
            $unixDateEnd = $date->getTimeStamp();

            $query->andFilterWhere(
                    ['between', 'role_master.created_at', $unixDateStart, $unixDateEnd]);
        }
        if (isset($updated_at) && !empty($updated_at)) {

            $date = \DateTime::createFromFormat('m-d-Y', $this->$updated_at);
            $date->setTime(0, 0, 0);

            // set lowest date value
            $unixDateStart = $date->getTimeStamp();

            // add 1 day and subtract 1 second
            $date->add(new \DateInterval('P1D'));
            $date->sub(new \DateInterval('PT1S'));

            // set highest date value
            $unixDateEnd = $date->getTimeStamp();

            $query->andFilterWhere(
                    ['between', 'role_master.updated_at', $unixDateStart, $unixDateEnd]);
        }
        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id
        ]);

        $query->andFilterWhere(['like', 'role_name', $this->role_name]);
        $query->andFilterWhere(['like', 'company_master.company_name', $this->company_id]);
//        echo $query->createCommand()->rawSql;exit;
        return $dataProvider;
    }

}
