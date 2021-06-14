<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use common\CommonFunction;

?>
<div class="card card-default color-palette-box">
    <div class="card-body">

        <p class="text-right">
            <?php if (isset(Yii::$app->user->identity) && CommonFunction::checkAccess('branch-update', Yii::$app->user->identity->id)) { ?>
                <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
            <?php } ?>
        </p>

        <div class="row">
            <div class="col-md-6 col-sm-12">
                <h4> Branch Details </h4>
                <?=
                DetailView::widget([
                    'model' => $model,
                    'attributes' => [
                        'branch_name',
                        'street_no',
                        'street_address',
                        'apt',
                        [
                            'attribute' => 'state',
                            'value' => isset($model->cityRef->stateRef->state) ? $model->cityRef->stateRef->state : '',
                        ],
                        [
                            'attribute' => 'city',
                            'value' => isset($model->cityRef->city) ? $model->cityRef->city : '',
                        ],
                        'zip_code'
                    ],
                ])
                ?>
            </div>

            <div class="col-md-6 col-sm-12">
                <h4> Owner Details </h4>
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
                        [
                            'attribute' => 'state',
                            'value' => isset($userDetailModel->cityRef->stateRef->state) ? $userDetailModel->cityRef->stateRef->state : '',
                        ],
                        [
                            'attribute' => 'city',
                            'value' => isset($userDetailModel->cityRef->city) ? $userDetailModel->cityRef->city : '',
                        ],
                        'zip_code',
                    ],
                ])
                ?>
            </div>
        </div>



    </div>
</div>
