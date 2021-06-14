<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Vendor */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Vendors', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>

<div class="card card-default color-palette-box">
    <div class="card-body">

        <p class="text-right">
            <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        </p>

        <div class="row">
            <div class="col-md-12 col-sm-12">
                <?=
                DetailView::widget([
                    'model' => $model,
                    'attributes' => [
                        'company_name',
                        'email:email',
                        'phone',
                        'street_no',
                        'street_address',
                        'apt',
                        'city',
                        'zip_code',
//                        'state',
                        [
                            'attribute' => 'state',
                            'value' => function ($model) {
                                return $model->states->state;
                            },
                        ],
                    ],
                ])
                ?>
            </div>
        </div>
    </div>
</div>
