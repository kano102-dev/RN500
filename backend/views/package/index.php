<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
?>

<div class="card card-default color-palette-box">
    <div class="card-body">

        <div class="col-12">
           <?= Html::a('Create Package Master', ['create'], ['class' => 'btn btn-primary float-right']) ?>

            <div class="table table-responsive">

                <?php Pjax::begin(); ?>
         <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'title',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

                <?php Pjax::end(); ?>
            </div>


        </div>
    </div>
    <!-- /.card-body -->
</div>