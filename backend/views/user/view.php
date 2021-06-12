<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use common\CommonFunction;

$this->title = 'User Approval';
$this->params['breadcrumbs'][] = ['label' => $this->title, 'url' => ['index']];
$this->params['breadcrumbs'][] = "View";
?>

<div class="card card-default color-palette-box">
    <div class="card-body">
        <div class="row">
            <div class="col-6">
                <h4> Company Details </h4>
                <?=
                DetailView::widget([
                    'model' => $companyMasterModel,
                    'attributes' => [
                        'company_name',
                        'company_email',
                        'company_mobile',
                        'employer_identification_number',
                        'website_link',
                        'street_no',
                        'street_address',
                        'apt',
                        [
                            'attribute' => 'city',
                            'value' => function ($model) {
                                return isset($model->cityRef->city) ? $model->cityRef->city . "-" . $model->cityRef->stateRef->state : '';
                            }
                        ],
                        'zip_code',
                        [
                            'attribute' => 'priority',
                            'value' => function ($model) {
                                return isset($model->priority) ? Yii::$app->params['company.priority'][$model->priority] : '';
                            }
                        ],
                    ],
                ])
                ?>
            </div>

            <div class="col-6">
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
                            'attribute' => 'city',
                            'value' => function ($model) {
                                return isset($model->cityRef->city) ? $model->cityRef->city . "-" . $model->cityRef->stateRef->state : '';
                            }
                        ],
                        'zip_code',
                    ],
                ])
                ?>
            </div>
        </div>
    </div>
</div>

