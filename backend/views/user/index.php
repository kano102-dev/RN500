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
    .table-responsive{
        margin-top: 12px;
    }
    .table{
        width:100%;
    }
</style>
<div class="card card-default color-palette-box">
    <div class="card-body">

        <div class="col-12">
            <section id="tabs" class="project-tab">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <nav>
                                <div class="nav nav-tabs nav-fill" id="nav-tab" role="tablist">
                                    <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#pending" role="tab" onclick="getPendingRecords()" aria-controls="nav-home" aria-selected="true">Approval Pending</a>
                                    <a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#approved" role="tab" onclick="getApprovedRecords()" aria-controls="nav-profile" aria-selected="false">Approved</a>
                                    <a class="nav-item nav-link" id="nav-contact-tab" data-toggle="tab" href="#rejected" role="tab" onclick="getRejectedRecords()" aria-controls="nav-contact" aria-selected="false">Rejected</a>
                                </div>
                            </nav>
                            <div class="tab-content" id="nav-tabContent">
                                <div class="tab-pane fade show active" id="pending" role="tabpanel" aria-labelledby="nav-home-tab">
                                    <div class="table-responsive">
                                        <table class="table table-bordered" cellspacing="0" id="table-pending">
                                            <thead>
                                                <tr style=" color: #337ab7 !important;background:#e5eaef !important; "><th>#</th>
                                                    <th>Unique Id</th>
                                                    <th>Name</th>
                                                    <th>Email</th>
                                                    <th>Company</th>
                                                    <th>User Type</th>
                                                    <th style="width:5%">Action</th>
                                                </tr>
                                            </thead>

                                            <tbody>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="approved" role="tabpanel" aria-labelledby="nav-profile-tab">
                                    <div class="table-responsive">
                                        <table class="table table-bordered" cellspacing="0" id="table-approved">
                                            <thead>
                                                <tr style=" color: #337ab7 !important;background:#e5eaef !important; "><th>#</th>
                                                    <th>Unique Id</th>
                                                    <th>Name</th>
                                                    <th>Email</th>
                                                    <th>Company</th>
                                                    <th>User Type</th>
                                                    <th>Comment</th>
                                                </tr>
                                            </thead>

                                            <tbody>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="rejected" role="tabpanel" aria-labelledby="nav-contact-tab">
                                    <div class="table-responsive">
                                        <table class="table table-bordered" cellspacing="0" id="table-rejected">
                                            <thead>
                                                <tr style=" color: #337ab7 !important;background:#e5eaef !important; "><th>#</th>
                                                    <th>Unique Id</th>
                                                    <th>Name</th>
                                                    <th>Email</th>
                                                    <th>Company</th>
                                                    <th>User Type</th>
                                                    <th>Comment</th>
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
            </section>
        </div>
    </div>
    <!-- /.card-body -->
</div>
<?php

$pending_url = Yii::$app->urlManagerAdmin->createAbsoluteUrl(['user/get-pending']);
$approved_url = Yii::$app->urlManagerAdmin->createAbsoluteUrl(['user/get-approved']);
$rejected_url = Yii::$app->urlManagerAdmin->createAbsoluteUrl(['user/get-rejected']);
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
                { "name": "type"},
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
                { "name": "type"},                
                { "name": "comment"},                
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
                { "name": "type"},
                { "name": "comment"},
            ],
            "bDestroy": true,
        });
    }
    $(document).on("click", ".change-status", function(){
        $("#commonModal").modal("show");
        $("#commonModal").find("#commonModalHeader").html($(this).attr('modal-title'));
        $("#commonModal").find("#modalContent").load($(this).attr("url"));
    });
JS;
$this->registerJS($script_new, 3);
?>