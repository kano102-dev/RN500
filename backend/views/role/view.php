<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\web\JsExpression;
use yii\helpers\Url;
use common\CommonFunction;

/* @var $this yii\web\View */
/* @var $model common\models\RoleMaster */

$this->title = 'Role Masters';
$this->params['breadcrumbs'][] = ['label' => $this->title, 'url' => ['index']];
$this->params['breadcrumbs'][] = "View";
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

        <p class="text-right">
            <?php if (isset(Yii::$app->user->identity) && CommonFunction::checkAccess('role-update', Yii::$app->user->identity->id)) { ?>
                <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
            <?php } ?>

        </p>

        <div class="row">
            <div class="col-md-12 col-sm-12">
                <h4> Role Details </h4>
                <?=
                DetailView::widget([
                    'model' => $model,
                    'attributes' => [
                        'role_name'
                    ],
                ])
                ?>
            </div>
            <div class="col-md-6 col-sm-12">
                <h4> Permissions </h4>
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
            </div>


        </div>


    </div>
</div>
