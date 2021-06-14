<?php

use yii\helpers\Html;

/* @var $this yii\web\View */

/* @var $user common\models\User */
?>

<p>Hii <?php echo $model->to_name ?>, </p>
<br/>


<p> You are invited by <b> <?php echo $model->from_name ?></b> ( <?php echo $model->from_email ?>) to review / apply following job. </p>
<br/>

<p><a href="<?php echo $referralLink ?>" target="_blank" > Click here </a> to view the job details </p>

<br/>

<?php if ($model->description != '') { ?>
    Comment : <?php echo $model->description ?>
<?php } ?>



<br/><br/>
Regards,<br/> 

