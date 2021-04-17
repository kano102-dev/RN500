<?php

use yii\helpers\Html;
?>

<div class="middle-box text-center animated fadeInDown">
<?php if (isset($exception->statusCode) && !empty($exception->statusCode)) { ?>
        <h1><?php echo $exception->statusCode ?></h1>
        <h3 class="font-bold">

        <?php echo nl2br(Html::encode($exception->getmessage())) ?>
        </h3>
<?php } else { ?>
        <h1>500</h1>
        <h3 class="font-bold"><?php echo "Something Went Wrong."; ?></h3>
<?php } ?>

    <div class="error-desc">
    </div>
</div>
