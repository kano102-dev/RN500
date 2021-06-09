<?php

use common\CommonFunction;
use common\models\User;

$controller = Yii::$app->controller->id;
$action = Yii::$app->controller->action->id;
?>
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="<?= \yii\helpers\Url::home() ?>" class="brand-link">
        <img src="<?= Yii::$app->urlManagerAdmin->createUrl('//'); ?>/images/RN500_logo.jpg" alt="RN500" class="brand-image img-circle elevation-3"
             style="opacity: .8">
        <span class="brand-text font-weight-light">RN500</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <!--        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                    <div class="image">
                        <img src="<?= $assetDir ?>/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
                    </div>
                    <div class="info">
                        <a href="#" class="d-block"></a>
                    </div>
                </div>-->

        <!-- Sidebar Menu -->
        <nav class="mt-2">

            <?php
            echo \hail812\adminlte3\widgets\Menu::widget([
                'items' => [
                    [
                        'label' => 'Home',
                        'url' => ['site/index'],
                        'icon' => 'tachometer-alt',
                        'active' => ($controller == "site" && $action == "index")
                    ],
                    [
                        'label' => 'Role',
                        'url' => ['role/index'],
                        'icon' => 'tasks',
                        'active' => ($controller == "role"),
                        'visible' => isset(Yii::$app->user->identity) ? CommonFunction::checkAccess('role-create', Yii::$app->user->identity->id) || CommonFunction::checkAccess('role-update', Yii::$app->user->identity->id) || CommonFunction::checkAccess('role-delete', Yii::$app->user->identity->id) || CommonFunction::checkAccess('role-view', Yii::$app->user->identity->id) : false
                    ],
                    [
                        'label' => 'Package',
                        'url' => ['package/index'],
                        'icon' => 'book',
                        'active' => ($controller == "package"),
                        'visible' => isset(Yii::$app->user->identity) ? CommonFunction::checkAccess('package-create', Yii::$app->user->identity->id) || CommonFunction::checkAccess('package-update', Yii::$app->user->identity->id) || CommonFunction::checkAccess('package-delete', Yii::$app->user->identity->id) || CommonFunction::checkAccess('package-view', Yii::$app->user->identity->id) : false
                    ],
                    [
                        'label' => 'Branch',
                        'url' => ['company-branch/index'],
                        'icon' => 'sitemap',
                        'active' => ($controller == "company-branch"),
                        'visible' => isset(Yii::$app->user->identity) ? CommonFunction::checkAccess('branch-create', Yii::$app->user->identity->id) || CommonFunction::checkAccess('branch-update', Yii::$app->user->identity->id) || CommonFunction::checkAccess('branch-delete', Yii::$app->user->identity->id) || CommonFunction::checkAccess('branch-view', Yii::$app->user->identity->id) : false
                    ],
                    [
                        'label' => 'Recruiter Company',
                        'url' => ['recruiter/index'],
                        'icon' => 'users',
                        'active' => ($controller == "recruiter"),
                        'visible' => isset(Yii::$app->user->identity) ? CommonFunction::checkAccess('recruiter-create', Yii::$app->user->identity->id) || CommonFunction::checkAccess('recruiter-update', Yii::$app->user->identity->id) || CommonFunction::checkAccess('recruiter-delete', Yii::$app->user->identity->id) || CommonFunction::checkAccess('recruiter-view', Yii::$app->user->identity->id) : false
                    ],
                    [
                        'label' => 'Employer Company',
                        'url' => ['employer/index'],
                        'icon' => 'hospital-alt',
                        'active' => ($controller == "employer"),
                        'visible' => isset(Yii::$app->user->identity) ? CommonFunction::checkAccess('employer-update', Yii::$app->user->identity->id) || CommonFunction::checkAccess('employer-delete', Yii::$app->user->identity->id) || CommonFunction::checkAccess('employer-view', Yii::$app->user->identity->id) : false
                    ],
                    [
                        'label' => 'Staff Management',
                        'url' => ['staff/index'],
                        'icon' => 'user-friends',
                        'active' => ($controller == "staff"),
                        'visible' => isset(Yii::$app->user->identity) ? CommonFunction::checkAccess('user-create', Yii::$app->user->identity->id) || CommonFunction::checkAccess('user-update', Yii::$app->user->identity->id) || CommonFunction::checkAccess('user-delete', Yii::$app->user->identity->id) || CommonFunction::checkAccess('user-view', Yii::$app->user->identity->id) : false
                    ],
                    [
                        'label' => 'User Approval',
                        'url' => ['user/index'],
                        'icon' => 'user-check',
                        'active' => ($controller == "user"),
                        'visible' => isset(Yii::$app->user->identity) ? CommonFunction::checkAccess('user-approve', Yii::$app->user->identity->id) || CommonFunction::checkAccess('user-request-view', Yii::$app->user->identity->id) : false
                    ],
                    [
                        'label' => 'Lead Approval',
                        'url' => ['lead/index'],
                        'icon' => 'clipboard-check',
                        'active' => ($controller == "lead"),
                        'visible' => isset(Yii::$app->user->identity) && CommonFunction::checkAccess('lead-verify', Yii::$app->user->identity->id) ?: false
                    ],
                    [
                        'label' => 'Benefits',
                        'url' => ['/benefits'],
                        'icon' => 'user-check',
                        'active' => ($controller == "benefits"),
                        'visible' => isset(Yii::$app->user->identity) ? CommonFunction::checkAccess('benefits-create', Yii::$app->user->identity->id) || CommonFunction::checkAccess('benefits-update', Yii::$app->user->identity->id) || CommonFunction::checkAccess('benefits-delete', Yii::$app->user->identity->id) || CommonFunction::checkAccess('benefits-view', Yii::$app->user->identity->id) : false
                    ],
                    [
                        'label' => 'Specialty',
                        'url' => ['/speciality'],
                        'icon' => 'user-check',
                        'active' => ($controller == "speciality"),
                        'visible' => isset(Yii::$app->user->identity) ? CommonFunction::checkAccess('specialty-create', Yii::$app->user->identity->id) || CommonFunction::checkAccess('specialty-update', Yii::$app->user->identity->id) || CommonFunction::checkAccess('specialty-delete', Yii::$app->user->identity->id) || CommonFunction::checkAccess('specialty-view', Yii::$app->user->identity->id) : false
                    ],
                    [
                        'label' => 'Discipline',
                        'url' => ['/discipline'],
                        'icon' => 'user-check',
                        'active' => ($controller == "discipline"),
                        'visible' => isset(Yii::$app->user->identity) ? CommonFunction::checkAccess('decipline-create', Yii::$app->user->identity->id) || CommonFunction::checkAccess('decipline-update', Yii::$app->user->identity->id) || CommonFunction::checkAccess('decipline-delete', Yii::$app->user->identity->id) || CommonFunction::checkAccess('decipline-view', Yii::$app->user->identity->id) : false
                    ],
                    [
                        'label' => 'Advertisement',
                        'url' => ['/advertisement'],
                        'icon' => 'user-check',
                        'active' => ($controller == "advertisement"),
                        'visible' => isset(Yii::$app->user->identity) ? CommonFunction::checkAccess('create-advertisement', Yii::$app->user->identity->id) || CommonFunction::checkAccess('update-advertisement', Yii::$app->user->identity->id) || CommonFunction::checkAccess('delete-advertisement', Yii::$app->user->identity->id) || CommonFunction::checkAccess('view-advertisement', Yii::$app->user->identity->id) : false
                    ],
                    [
                        'label' => 'Vendor',
                        'url' => ['/vendor'],
                        'icon' => 'user-check',
                        'active' => ($controller == "vendor"),
                        'visible' => isset(Yii::$app->user->identity) ? CommonFunction::checkAccess('create-vendor', Yii::$app->user->identity->id) || CommonFunction::checkAccess('update-vendor', Yii::$app->user->identity->id) || CommonFunction::checkAccess('delete-vendor', Yii::$app->user->identity->id) || CommonFunction::checkAccess('view-vendor', Yii::$app->user->identity->id) : false
                    ],
                    [
                        'label' => 'Emergency',
                        'url' => ['/emergency'],
                        'icon' => 'user-check',
                        'active' => ($controller == "emergency"),
                        'visible' => isset(Yii::$app->user->identity) ? CommonFunction::checkAccess('emergency-create', Yii::$app->user->identity->id) || CommonFunction::checkAccess('emergency-update', Yii::$app->user->identity->id) || CommonFunction::checkAccess('emergency-delete', Yii::$app->user->identity->id) || CommonFunction::checkAccess('emergency-view', Yii::$app->user->identity->id) : false
                    ],
                ],
            ]);
            ?>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>