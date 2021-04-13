<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use common\CommonFunction;

$this->title = 'Package';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="card card-default color-palette-box">
    <div class="card-body">

        <div class="col-12">
            <?php if (isset(Yii::$app->user->identity) && CommonFunction::checkAccess('package-create', Yii::$app->user->identity->id)) { ?>
                <?= Html::a('Create Package', ['create'], ['class' => 'btn btn-primary float-right']) ?>
            <?php } ?>

            <div class="table table-responsive">

                <?php Pjax::begin(); ?>
                <?=
                GridView::widget([
                    'dataProvider' => $dataProvider,
                    'filterModel' => $searchModel,
                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn'],
                        'title',
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