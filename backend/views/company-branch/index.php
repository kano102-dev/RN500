<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

$this->title = 'Branch';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="card card-default color-palette-box">
    <div class="card-body">

        <div class="col-12">
            <?= Html::a('Create Company Branch', ['create'], ['class' => 'btn btn-primary float-right']) ?>

            <div class="table table-responsive">

                <?php Pjax::begin(); ?>
                <?=
                GridView::widget([
                    'dataProvider' => $dataProvider,
                    'filterModel' => $searchModel,
                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn'],
                        'branch_name',
                        'street_no',
                        'street_address',
                        [
                            'attribute' => 'company_id',
                            'value' => function ($model) {
                                return $model->company->company_name;
                            }
                        ],
                        //'suit/apt',
                        //'city',
                        //'zip_code',
                        //'is_default',
                        //'created_at',
                        //'updated_at',
                        ['class' => 'yii\grid\ActionColumn'],
                    ],
                ]);
                ?>

                <?php Pjax::end(); ?>
            </div>


        </div>
    </div>
    <!-- /.card-body -->
</div>