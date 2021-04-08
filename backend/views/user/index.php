<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\Url;
use common\models\User;

/* @var $this yii\web\View */
/* @var $searchModel app\models\AssetTransferSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
?>
<style>
    table{
        width: 100% !important;
    }
</style>
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">

                <div class="tabs-container my-team-leave-tabs">
                    <ul class="nav nav-tabs">
                        <li class="active"><a data-toggle="tab" href="#pending" onclick="getPendingRecords()">Approval Pending </a></li>
                        <li class=""><a data-toggle="tab" href="#approved" onclick="getApprovedRecords()">Approved </a></li>
                        <li class=""><a data-toggle="tab" href="#rejected" onclick="getRejectedRecords();">Rejected </a></li>
                    </ul>

                    <div class="tab-content">
                        <div class="tab-pane" id="pending">
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="table-responsive">
                                            <div class="invite_tab_content">
                                                <table class="table table-hover table-bordered" id="table-pending">
                                                    <thead>
                                                        <tr style=" color: #337ab7 !important;background:#e5eaef !important; "><th>#</th>
                                                            <th>Unique Id</th>
                                                            <th>Name</th>
                                                            <th>Email</th>
                                                            <th>Company</th>
                                                            <th style="width:5%">Action</th>
                                                        </tr>
                                                    </thead>

                                                    <tbody>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane" id="approved">
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="table-responsive">
                                            <div class="invite_tab_content">
                                                <table class="table table-hover table-bordered" id="table-approved">
                                                    <thead>
                                                        <tr style=" color: #337ab7 !important;background:#e5eaef !important; "><th>#</th>
                                                            <th>Unique Id</th>
                                                            <th>Name</th>
                                                            <th>Email</th>
                                                            <th>Company</th>
                                                            <th style="width:5%">Action</th>
                                                        </tr>
                                                    </thead>

                                                    <tbody>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane" id="rejected">
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="table-responsive">
                                            <div class="invite_tab_content">
                                                <table class="table table-hover table-bordered" id="table-rejected">
                                                    <thead>
                                                        <tr style=" color: #337ab7 !important;background:#e5eaef !important; "><th>#</th>
                                                            <th>Unique Id</th>
                                                            <th>Name</th>
                                                            <th>Email</th>
                                                            <th>Company</th>
                                                            <th style="width:5%">Action</th>
                                                        </tr>
                                                    </thead>

                                                    <tbody>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>  
</div>  
<?php

$pending_url = Yii::$app->urlManager->createAbsoluteUrl(['user/get-pending']);
$approved_url = Yii::$app->urlManager->createAbsoluteUrl(['user/get-approved']);
$rejected_url = Yii::$app->urlManager->createAbsoluteUrl(['user/get-rejected']);
$pageLength = 10;
$csrfParam = Yii::$app->request->csrfParam;
$csrfToken = Yii::$app->request->getCsrfToken();
$script_new = <<<JS
let draw = 1;
getPendingRecords();
        
    function getPendingRecords() {
        draw++;
        $('#table-pending').DataTable({
            "pageLength": $pageLength,
            "serverSide": true,
            "ajax": {
                "url": "$pending_url", "type": "POST", "data": function (d) {
                    d.$csrfParam = "$csrfToken";
                }, error: function (xhr, error, code) {
                    if (xhr.status == 403 || xhr.status == 400) {
                        location.reload();
                    }
                }
            },
            "aaSorting": [],
            "columns": [
                {"name": "s.no", "orderable": false},
                {"name": "unique_id"},
                {"name": "name"},
                { "name": "email"},
                { "name": "company_name"},
                {"name": "actions", "orderable": false},
            ],
            "bDestroy": true,
        });
    }
    function getRejectedRecords() {
        draw++;
        $('#table-rejected').DataTable({
            "pageLength": $pageLength,
            "serverSide": true,
            "ajax": {
                "url": "$rejected_url", "type": "POST", "data": function (d) {
                    d.$csrfParam = "$csrfToken";
                }, error: function (xhr, error, code) {
                    if (xhr.status == 403 || xhr.status == 400) {
                        location.reload();
                    }
                }
            },
            "aaSorting": [],
            "columns": [
                {"name": "s.no", "orderable": false},
                {"name": "unique_id"},
                {"name": "name"},
                { "name": "email"},
                { "name": "company_name"},
                {"name": "actions", "orderable": false},
            ],
            "bDestroy": true,
        });
    }
    function getApprovedRecords() {
        draw++;
        $('#table-approved').DataTable({
            "pageLength": $pageLength,
            "serverSide": true,
            "ajax": {
                "url": "$approved_url", "type": "POST", "data": function (d) {
                    d.$csrfParam = "$csrfToken";
                }, error: function (xhr, error, code) {
                    if (xhr.status == 403 || xhr.status == 400) {
                        location.reload();
                    }
                }
            },
            "aaSorting": [],
            "columns": [
                {"name": "s.no", "orderable": false},
                {"name": "unique_id"},
                {"name": "name"},
                { "name": "email"},
                { "name": "company_name"},
                {"name": "actions", "orderable": false},
            ],
            "bDestroy": true,
        });
    }
//    $(document).on("click", ".change-status", function(){
//    $("#commonModal").modal("show");
//    $("#commonModal").find("#commonModalHeader").html($(this).attr('modal-title'));
//    $("#commonModal").find("#modalContent").load($(this).attr("url"));
});
JS;
$this->registerJS($script_new, 3);
?>