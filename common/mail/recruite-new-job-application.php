<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $user common\models\User */

$jobSeekerProfileUser = Yii::$app->urlManagerFrontend->createAbsoluteUrl(['/profile/user-summary', 'ref' => $job_seeker->details->unique_id]);

?>
<div class="login-otp">
    <br/>
    <p> Hii</p> 
    <p> New job appliation received from <?php echo $job_seeker->getFullName() ?>  for position of <b><?php echo $lead->title ?> <b> (Ref. No. :  <?php echo $lead->reference_no ?>)</p> 

                <p> <a href="<?php echo $jobSeekerProfileUser ?>" target="_blank"> Click here </a> to view job seeker profile </p> 

                <br/>
                or copy paste the following url into browser
                <br/><br/>
                <?php echo $jobSeekerProfileUser ?>
                <br/>


                <br/><br/><br/><br/>
                Regards,
                </div>
