<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $user common\models\User */
?>
<div class="login-otp">
    <br/>
    <p> Hii</p> 
    <p> New job appliation received from <?php echo $job_seeker->getFullName() ?>  for position of <b><?php echo $lead->title ?> </b> (Ref. No. :  <?php echo $lead->reference_no ?>)</p> 

    <p> <a href="<?php echo $urlToSend ?>" target="_blank"> Click here </a> to view job seeker profile </p> 

    <br/>
    or copy paste the following url into browser
    <br/><br/>
    <?php echo $urlToSend ?>
    <br/>


    <br/><br/><br/><br/>
    Regards,
</div>
