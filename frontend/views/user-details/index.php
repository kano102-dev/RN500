<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel frontend\models\UserDetailsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'User Details';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-details-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create User Details', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'user_id',
            'unique_id',
            'first_name',
            'last_name',
            //'mobile_no',
            //'street_no',
            //'street_address',
            //'apt',
            //'city',
            //'zip_code',
            //'profile_pic',
            //'current_position',
            //'speciality',
            //'looking_for:ntext',
            //'dob',
            //'work experience',
            //'job_title',
            //'job_looking_from',
            //'travel_preference',
            //'ssn',
            //'work_authorization',
            //'work_authorization_comment:ntext',
            //'license_suspended:ntext',
            //'professional_liability:ntext',
            //'created_at',
            //'updated_at',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>
