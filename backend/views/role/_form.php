<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\web\JsExpression;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model common\models\RoleMaster */
/* @var $form yii\widgets\ActiveForm */
$this->title = 'Role Masters';
?>
<style type="text/css">
    .fancytree-checkbox {
        float: right;
    }    

    .fancytree-node {
        display: block;
        margin: 5px 0;
        padding: 5px 10px;
        color: #333;
        text-decoration: none;
        border: 1px solid #e7eaec;
        background: #f5f5f5;
        -webkit-border-radius: 3px;
        border-radius: 3px;
        box-sizing: border-box;
    }

    ul.fancytree-container {
        border: 0px !important;
    }
    .label-role {
        min-width: 200px !important; 
        display: inline-block !important; 
        padding-top:5px; 
        padding-bottom:5px;
        cursor: pointer;
    }

    .tabs-container .tabs-left > .nav-tabs, .tabs-container .tabs-right > .nav-tabs {
        width: 32%;
    }

    .tabs-container .tabs-left .panel-body {
        width: 68%;
        margin-left: 32%;
    }
    .action-items {
        position:relative; 
        margin-top:-32px; 
        padding-right:8px;
        float:right;
    }

    .tabs-container .nav > li.active {
        margin-right: 0px;
        color: #000000;
    }

    .role-nav {
        padding-left: 10px !important;
    }

    /*    .nav-tabs > li > a {
            color: #A7B1C2 !important;
            font-weight: 600;
            padding: 10px 20px 10px 25px;
        }*/

    .tabs-container .nav > li a:hover, .tabs-container .nav > li a:focus, .tabs-container .nav > li a:active {
        background: none !important;
        color: #000000 !important;
        border: 0px;
    }

    .tabs-container .nav > li > a {
        color: #A7B1C2 !important;
    }

    .tabs-container .nav > li.active > a {
        color: #000000 !important;
    }   
</style>
<div class="card card-default color-palette-box">
    <div class="card-body">
        <?php
        $form = ActiveForm::begin(['id' => 'role_form', 'enableClientValidation' => true,
                    'enableAjaxValidation' => false]);
        ?>
        <div class="row">
            <div class="col-6">
                <?= $form->field($model, 'role_name')->textInput(['maxlength' => true]) ?>
            </div>
        </div>
        <div class="row">
            <div class="col-6">
                <h3>Permissions</h3>
                <?=
                \wbraganca\fancytree\FancytreeWidget::widget([
                    'options' => [
                        'source' => $tree,
                        'extensions' => ['dnd'],
                        'checkbox' => true,
                        'icon' => false,
                        'tooltip' => true,
                        'selectMode' => 3,
                        'activeVisible' => true,
                        'dnd' => [
                            'preventVoidMoves' => true,
                            'preventRecursiveMoves' => true,
                            'autoExpandMS' => 400,
                            'dragStart' => new JsExpression('function(node, data) {
				return true;
			}'),
                            'dragEnter' => new JsExpression('function(node, data) {
				return true;
			}'),
                            'dragDrop' => new JsExpression('function(node, data) {
				data.otherNode.moveTo(node, data.hitMode);
			}'),
                        ],
                    ]
                ]);
                ?>
                <div class="help-block" id="permission_error" style="color: #a94442;"></div>
            </div>
        </div>
        <div class="form-group">
            <?= Html::submitButton('Save', ['class' => 'btn btn-primary']) ?>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>
<?php
$script = <<< JS
$('form#role_form').on('beforeSubmit', function(e) {
    e.preventDefault
   var permissions=new Array();
   var form = $(this);
   var tree_data=$('#fancyree_w0').fancytree('getTree').getSelectedNodes();
   tree_data.forEach(function(d) {
   if(d.children==null){
        permissions.push(d.key);
   }
  });
  if (permissions.length === 0) {
    $('#permission_error').html("Select atleast one permission");
        return false;
  }
  var formData = form.serialize()+"&RoleMaster[permissions]="+permissions;
  $.ajax({
        url: form.attr("action"),
        type: "post",
        data: formData,
        success: function (data) {
            
        }
    });
}).on('submit', function(e){
    e.preventDefault();
});
JS;
$this->registerJs($script);
?>