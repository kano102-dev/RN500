<?php
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
                    //  ['label' => 'Role'],
                    // [
                    //     'label' => 'Starter Pages',
                    //     'icon' => 'tachometer-alt',
                    //     'badge' => '<span class="right badge badge-info">2</span>',
                    //     'items' => [
                    //         ['label' => 'Active Page', 'url' => ['site/index'], 'iconStyle' => 'far'],
                    //         ['label' => 'Inactive Page', 'iconStyle' => 'far'],
                    //     ]
                    // ],
                    // ['label' => 'Simple Link', 'icon' => 'th', 'badge' => '<span class="right badge badge-danger">New</span>'],
                    // ['label' => 'Yii2 PROVIDED', 'header' => true],
                    // ['label' => 'Login', 'url' => ['site/login'], 'icon' => 'sign-in-alt', 'visible' => Yii::$app->user->isGuest],
                    // ['label' => 'Gii',  'icon' => 'file-code', 'url' => ['/gii'], 'target' => '_blank'],
                    // ['label' => 'Debug', 'icon' => 'bug', 'url' => ['/debug'], 'target' => '_blank'],
                    // ['label' => 'MULTI LEVEL EXAMPLE', 'header' => true],
                    // ['label' => 'Level1'],
                    // [
                    //     'label' => 'Level1',
                    //     'items' => [
                    //         ['label' => 'Level2', 'iconStyle' => 'far'],
                    //         [
                    //             'label' => 'Level2',
                    //             'iconStyle' => 'far',
                    //             'items' => [
                    //                 ['label' => 'Level3', 'iconStyle' => 'far', 'icon' => 'dot-circle'],
                    //                 ['label' => 'Level3', 'iconStyle' => 'far', 'icon' => 'dot-circle'],
                    //                 ['label' => 'Level3', 'iconStyle' => 'far', 'icon' => 'dot-circle']
                    //             ]
                    //         ],
                    //         ['label' => 'Level2', 'iconStyle' => 'far']
                    //     ]
                    // ],
                    // ['label' => 'Level1'],
                    // ['label' => 'LABELS', 'header' => true],
                    // ['label' => 'Important', 'iconStyle' => 'far', 'iconClassAdded' => 'text-danger'],
                    // ['label' => 'Warning', 'iconClass' => 'nav-icon far fa-circle text-warning'],
                    // ['label' => 'Informational', 'iconStyle' => 'far', 'iconClassAdded' => 'text-info'],
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
                        'active' => ($controller == "role")
                    ],
                        [
                        'label' => 'Package',
                        'url' => ['package/index'],
                        'icon' => 'book',
                        'active' => ($controller == "package")
                    ],
                        [
                        'label' => 'Company Branch',
                        'url' => ['company-branch/index'],
                        'icon' => 'sitemap',
                        'active' => ($controller == "company-branch")
                    ],
                        [
                        'label' => 'Recruiter Management',
                        'url' => ['recruiter/index'],
                        'icon' => 'users',
                        'active' => ($controller == "recruiter")
                    ],
                        [
                        'label' => 'Staff Management',
                        'url' => ['staff/index'],
                        'icon' => 'user-friends',
                        'active' => ($controller == "staff")
                    ],
                    [
                        'label' => 'User Approval',
                        'url' => ['user/index'],
                        'icon' => 'user-check',
                        'active' => ($controller == "user")
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
                        'active' => ($controller == "benefits")
                    ],
                    [
                        'label' => 'Speciality',
                        'url' => ['/speciality'],
                        'icon' => 'user-check',
                        'active' => ($controller == "speciality")
                    ],
                    [
                        'label' => 'Discipline',
                        'url' => ['/discipline'],
                        'icon' => 'user-check',
                        'active' => ($controller == "discipline")
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