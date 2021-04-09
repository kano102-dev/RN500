<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$form = ActiveForm::begin(['id' => 'approval-form']);
?>
<?= $form->field($model, 'comment')->textarea(['rows' => 3, 'maxlength' => true]) ?>

<div class="form-group">
    <?= Html::button('Cancel', ['class' => 'btn btn-secondary', 'id' => "close", 'data-dismiss' => "modal"]) ?>
    <?php echo Html::submitButton('Apply', ['class' => 'btn btn-primary']) ?>
</div>
<?php ActiveForm::end(); ?>