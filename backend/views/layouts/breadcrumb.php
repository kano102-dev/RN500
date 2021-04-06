<?php
$module = Yii::$app->controller->module->id;
$controller = Yii::$app->controller->id;
$action = Yii::$app->controller->action->id;

$breadcrumbs = isset(Yii::$app->controller->breadcrumb) ? Yii::$app->controller->breadcrumb : [];
$activeBreadcrumb = isset(Yii::$app->controller->activeBreadcrumb) ? Yii::$app->controller->activeBreadcrumb : '';
?>
<?php if ($breadcrumbs) { ?>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <?php
            $cnt = 0;
            $totalBreadcrumbs = count($breadcrumbs);
            ?>
            <?php foreach ($breadcrumbs as $label => $url) { ?>
                <?php $cnt++; ?>
                <?php if ($action == 'index' && $totalBreadcrumbs == $cnt) { ?>
                    <li class="breadcrumb-item active"><?php echo $label ?></li>
                <?php } else { ?>
                    <li class="breadcrumb-item"><a href="<?php echo $url ?>"><?php echo $label ?></a></li>
                <?php } ?>
            <?php } ?>
            <?php if ($activeBreadcrumb) { ?>
                <li class="breadcrumb-item active" aria-current="page"> <?php echo $activeBreadcrumb ?></li>
                <?php } ?>
        </ol>
    </nav>
    <?php
}