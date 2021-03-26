<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel common\models\RoleMasterSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Role Masters';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="role-master-index">
    <p>
        <?= Html::a('Create Role', 'javascript:void(0)', ['class' => 'btn btn-success', 'id' => 'create_role','modal-title'=>'Create Role','url'=> yii\helpers\Url::to(['role/create'])]) ?>
    </p>

    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]);  ?>

    <?=
    GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'role_name',
            [
                'attribute' => 'created_at',
                'value' => function ($model) {
                    return date($model->created_at);
                }
            ],
//            'created_at',
//            'updated_at',
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]);
    ?>

    <?php Pjax::end(); ?>

</div>
<?php
$js = <<< JS
$(document).on("click", "#create_role", function(e) {
    $("#commonModal").modal("show");
    $("#commonModal").find("#commonModalHeader").html($(this).attr('modal-title'));
    $("#commonModal").find("#modalContent").load($(this).attr("url"));
});
JS;
$this->registerJs($js);
?>