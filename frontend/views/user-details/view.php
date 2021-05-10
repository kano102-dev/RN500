<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model frontend\models\UserDetails */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'User Details', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="user-details-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'user_id',
            'unique_id',
            'first_name',
            'last_name',
            'mobile_no',
            'street_no',
            'street_address',
            'apt',
            'city',
            'zip_code',
            'profile_pic',
            'current_position',
            'speciality',
            'looking_for:ntext',
            'dob',
            'work experience',
            'job_title',
            'job_looking_from',
            'travel_preference',
            'ssn',
            'work_authorization',
            'work_authorization_comment:ntext',
            'license_suspended:ntext',
            'professional_liability:ntext',
            'created_at',
            'updated_at',
        ],
    ]) ?>

</div>
