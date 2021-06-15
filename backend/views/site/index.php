<div class="container-fluid">
    <?php if (common\CommonFunction::isMasterAdmin(Yii::$app->user->identity->id)) { ?>
        <div class="row">
            <div class="col-md-4 col-sm-6 col-12">
                <div class="info-box">
                    <span class="info-box-icon bg-info"><i class="fa fa-users"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-text">Recruiter</span>
                        <span class="info-box-number"><?= isset($counts['recruiter']) && !empty($counts['recruiter']) ? $counts['recruiter'] : 0 ?></span>
                    </div>
                    <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
            </div>
            <div class="col-md-4 col-sm-6 col-12">
                <div class="info-box">
                    <span class="info-box-icon bg-info"><i class="fa fa-hospital-alt"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-text">Employer</span>
                        <span class="info-box-number"><?= isset($counts['employer']) && !empty($counts['employer']) ? $counts['employer'] : 0 ?></span>
                    </div>
                    <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
            </div>
            <div class="col-md-4 col-sm-6 col-12">
                <div class="info-box">
                    <span class="info-box-icon bg-info"><i class="fa fa-user-md"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-text">Jobseeker</span>
                        <span class="info-box-number"><?= isset($counts['jobseeker']) && !empty($counts['jobseeker']) ? $counts['jobseeker'] : 0 ?></span>
                    </div>
                    <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
            </div>
        </div>
    <?php } ?>
    <div class="row">
        <div class="col-md-4 col-sm-6 col-12">
            <div class="info-box">
                <span class="info-box-icon bg-info"><i class="fa fa-briefcase"></i></span>

                <div class="info-box-content">
                    <span class="info-box-text">Lead</span>
                    <span class="info-box-number"><?= isset($counts['lead']) && !empty($counts['lead']) ? $counts['lead'] : 0 ?></span>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>
        <div class="col-md-4 col-sm-6 col-12">
            <div class="info-box">
                <span class="info-box-icon bg-info"><i class="fa fa-building"></i></span>

                <div class="info-box-content">
                    <span class="info-box-text">Branch</span>
                    <span class="info-box-number"><?= isset($counts['branch']) && !empty($counts['branch']) ? $counts['branch'] : 0 ?></span>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>
        <div class="col-md-4 col-sm-6 col-12">
            <div class="info-box">
                <span class="info-box-icon bg-info"><i class="fa fa-users"></i></span>

                <div class="info-box-content">
                    <span class="info-box-text">Staff</span>
                    <span class="info-box-number"><?= isset($counts['staff']) && !empty($counts['staff']) ? $counts['staff'] : 0 ?></span>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>
    </div>
</div>