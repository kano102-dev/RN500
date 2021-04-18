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
                        'label' => 'Recruiter',
                        'url' => ['recruiter/index'],
                        'icon' => 'users',
                        'active' => ($controller == "recruiter"),
                        'visible' => isset(Yii::$app->user->identity) ? CommonFunction::checkAccess('recruiter-create', Yii::$app->user->identity->id) || CommonFunction::checkAccess('recruiter-update', Yii::$app->user->identity->id) || CommonFunction::checkAccess('recruiter-delete', Yii::$app->user->identity->id) || CommonFunction::checkAccess('recruiter-view', Yii::$app->user->identity->id) : false
                    ],
                    [
                        'label' => 'Employer',
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
                        'active' => ($controller == "lead")
                    ],
                    [
                        'label' => 'Benefits',
                        'url' => ['/benefits'],
                        'icon' => 'user-check',
                        'active' => ($controller == "benefits"),
                        'visible' => isset(Yii::$app->user->identity) ? CommonFunction::isMasterAdmin(Yii::$app->user->identity->id) || Yii::$app->user->identity->type == User::TYPE_EMPLOYER : false
                    ],
                    [
                        'label' => 'Specialty',
                        'url' => ['/speciality'],
                        'icon' => 'user-check',
                        'active' => ($controller == "speciality"),
                        'visible' => isset(Yii::$app->user->identity) ? CommonFunction::isMasterAdmin(Yii::$app->user->identity->id) || Yii::$app->user->identity->type == User::TYPE_EMPLOYER : false
                    ],
                    [
                        'label' => 'Discipline',
                        'url' => ['/discipline'],
                        'icon' => 'user-check',
                        'active' => ($controller == "discipline"),
                        'visible' => isset(Yii::$app->user->identity) ? CommonFunction::isMasterAdmin(Yii::$app->user->identity->id) || Yii::$app->user->identity->type == User::TYPE_EMPLOYER : false
                    ],
                    [
                        'label' => 'Advertisement',
                        'url' => ['/advertisement'],
                        'icon' => 'user-check',
                        'active' => ($controller == "advertisement")
                    ],
                    [
                        'label' => 'Vendor',
                        'url' => ['/vendor'],
                        'icon' => 'user-check',
                        'active' => ($controller == "vendor")
                    ],
//                    [
//                        'label' => 'Starter Pages',
//                        'icon' => 'tachometer-alt',
//                        'badge' => '<span class="right badge badge-info">2</span>',
//                        'items' => [
//                            ['label' => 'Active Page', 'url' => ['site/index'], 'iconStyle' => 'far'],
//                            ['label' => 'Inactive Page', 'iconStyle' => 'far'],
//                        ]
//                    ],
//                    ['label' => 'Simple Link', 'icon' => 'th', 'badge' => '<span class="right badge badge-danger">New</span>'],
//                    ['label' => 'Yii2 PROVIDED', 'header' => true],
//                    ['label' => 'Login', 'url' => ['site/login'], 'icon' => 'sign-in-alt', 'visible' => Yii::$app->user->isGuest],
//                    ['label' => 'Gii', 'icon' => 'file-code', 'url' => ['/gii'], 'target' => '_blank'],
//                    ['label' => 'Debug', 'icon' => 'bug', 'url' => ['/debug'], 'target' => '_blank'],
//                    ['label' => 'MULTI LEVEL EXAMPLE', 'header' => true],
//                    ['label' => 'Level1'],
//                    [
//                        'label' => 'Level1',
//                        'items' => [
//                            ['label' => 'Level2', 'iconStyle' => 'far'],
//                            [
//                                'label' => 'Level2',
//                                'iconStyle' => 'far',
//                                'items' => [
//                                    ['label' => 'Level3', 'iconStyle' => 'far', 'icon' => 'dot-circle'],
//                                    ['label' => 'Level3', 'iconStyle' => 'far', 'icon' => 'dot-circle'],
//                                    ['label' => 'Level3', 'iconStyle' => 'far', 'icon' => 'dot-circle']
//                                ]
//                            ],
//                            ['label' => 'Level2', 'iconStyle' => 'far']
//                        ]
//                    ],
//                    ['label' => 'Level1'],
//                    ['label' => 'LABELS', 'header' => true],
//                    ['label' => 'Important', 'iconStyle' => 'far', 'iconClassAdded' => 'text-danger'],
//                    ['label' => 'Warning', 'iconClass' => 'nav-icon far fa-circle text-warning'],
//                    ['label' => 'Informational', 'iconStyle' => 'far', 'iconClassAdded' => 'text-info'],
                ],
            ]);
            ?>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>