<?php
/* * ****************************************************************************
 * Author: Iconflux Technologies
 * 
 * Created: 29/03/2017
 * Purpose: Layout of error.
 * 
 * Change Log:
 * ===========
 * Name            Date         Purpose
 * Mohan  Ahuja    29/03/2017   Created.
 * ***************************************************************************** */

use backend\assets\ErrorAsset;

$asset = ErrorAsset::register($this);
?>

<?php $this->beginPage() ?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title><?php echo Yii::$app->params['TITLE']; ?></title>

        <title>Error</title>
        <link rel="shortcut icon" href="<?= Yii::$app->urlManagerAdmin->createUrl('//'); ?>/images/favicon.ico">
        <?php $this->head() ?>
    </head>

    <?php $this->beginBody() ?>
    <body class="gray-bg">
        <?php echo $content ?>
    </body>
    <?php $this->endBody() ?>

</html>
<?php $this->endPage() ?>