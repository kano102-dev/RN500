<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

$this->title = 'Staff';
$this->params['breadcrumbs'][] = ['label' => $this->title, 'url' => ['index']];
$this->params['breadcrumbs'][] = "View";
?>

<div class="card card-default color-palette-box">
    <div class="card-body">


        <p class="text-right">
            <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>

        </p>

        <div class="row">
            <div class="col-12">
                <?=
                DetailView::widget([
                    'model' => $userDetailModel,
                    'attributes' => [
                        'first_name',
                        'last_name',
                        'email',
                        'mobile_no',
                        'street_no',
                        'street_address',
                        'apt',
                        'city',
                        'zip_code',
                    ],
                ])
                ?>
            </div>


        </div>


    </div>
</div>

