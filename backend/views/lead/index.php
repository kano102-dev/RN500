<?php

/* @var $this yii\web\View */
/* @var $searchModel app\models\AssetTransferSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
?>
<style>
    .table-responsive{
        margin-top: 12px;
    }
    .table{
        width:100% !important;
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
                                </div>
                            </nav>
                            <div class="tab-content" id="nav-tabContent">

                                <div class="tab-pane fade show active" id="pending" role="tabpanel" aria-labelledby="nav-home-tab">
                                    <div class="table-responsive">
                                        <table class="table table-bordered" cellspacing="0" id="table-pending">
                                            <thead>
                                                <tr style=" color: #337ab7 !important;background:#e5eaef !important; "><th>#</th>
                                                    <th>Reference No.</th>
                                                    <th>Title</th>
                                                    <th>Commision</th>
                                                    <th>Salary</th>
                                                    <th>Start Date</th>
                                                    <th>End Date</th>
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
                                                    <th>Reference No.</th>
                                                    <th>Title</th>
                                                    <th>Commision</th>
                                                    <th>Salary</th>
                                                    <th>Start Date</th>
                                                    <th>End Date</th>
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

$pending_url = Yii::$app->urlManagerAdmin->createAbsoluteUrl(['lead/get-pending']);
$approved_url = Yii::$app->urlManagerAdmin->createAbsoluteUrl(['lead/get-approved']);
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
                {"name": "reference_no"},
                {"name": "title"},
                {"name": "recruiter_commission"},
                {"name": "jobseeker_payment"},
                {"name": "start_date"},
                {"name": "end_date"},
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
                {"name": "reference_no"},
                {"name": "title"},
                {"name": "recruiter_commission"},
                {"name": "jobseeker_payment"},
                {"name": "start_date"},
                {"name": "end_date"},
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