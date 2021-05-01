<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use yii\bootstrap4\ActiveForm;
use kartik\select2\Select2;
use kartik\date\DatePicker;
use common\CommonFunction;
use yii\helpers\Url;
use yii\web\JsExpression;

$assetDir = Yii::$app->assetManager->getPublishedUrl('@themes/jobs-portal');
?>
<!-- Page Title start -->
<div class="pageTitle">
    <div class="container">
        <div class="row">
            <div class="col-md-6 col-sm-6">
                <h1 class="page-heading">Lead Purchase Detail</h1>
            </div>
        </div>
    </div>
</div>
<!-- Page Title End -->

<div class="listpgWraper">
    <div class="container"> 

        <!-- Job Header start -->
        <div class="job-header">
            <div class="jobinfo">
                <div class="row">
                    <div class="col-md-6">
                        <div class="jobimg"><img src="<?= $assetDir ?>/images/RN500_logo177X53.png" alt="RN500" /></div><br/><br/>
                        <h2><?= $model->title ?></h2>
                        <div class="ptext">Posted <?= CommonFunction::dateDiffInDays($model->created_at); ?> days ago</div>
                        <div class="salary">Estimated Pay: $<?= $model->jobseeker_payment ?>/<?= Yii::$app->params['job.payment_type'][$model->payment_type] ?></div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <ul class="jbdetail">
                            <li class="row">
                                <div class="col-md-6 col-xs-6">Job Id</div>
                                <div class="col-md-6 col-xs-6"><span><?= $model->reference_no ?></span></div>
                            </li>
                            <li class="row">
                                <div class="col-md-6 col-xs-6">Location</div>
                                <div class="col-md-6 col-xs-6"><span><?= $model->branch->location ?></span></div>
                            </li>
                            <li class="row">
                                <div class="col-md-6 col-xs-6">Employment Status</div>
                                <div class="col-md-6 col-xs-6"><span><?= Yii::$app->params['job.type'][$model->job_type] ?></span></div>
                            </li>
                            <li class="row">
                                <div class="col-md-6 col-xs-6">Shift</div>
                                <div class="col-md-6 col-xs-6"><span><?= Yii::$app->params['job.shift'][$model->shift] ?></span></div>
                            </li>
                            <li class="row">
                                <div class="col-md-6 col-xs-6">Start Date</div>
                                <div class="col-md-6 col-xs-6"><span><?= $model->start_date ?></span></div>
                            </li>
                        </ul>
                    </div>
                    <div class="col-md-6">
                        <ul class="jbdetail">
                            <li class="row">
                                <div class="col-md-6 col-xs-6">Commission</div>
                                <div class="col-md-6 col-xs-6"><span><?= $model->recruiter_commission_type == 1 ? $model->recruiter_commission . "%" : '$' . $model->recruiter_commission ?></span></div>
                            </li>
                            <li class="row">
                                <div class="col-md-6 col-xs-6">Commission Type</div>
                                <div class="col-md-6 col-xs-6"><span><?= Yii::$app->params['COMMISSION_MODE'][$model->recruiter_commission_mode] ?></span></div>
                            </li>
                            <li class="row">
                                <div class="col-md-6 col-xs-6">Discipline</div>
                                <div class="col-md-6 col-xs-6"><span><?= $model->disciplineNames ?></span></div>
                            </li>
                            <li class="row">
                                <div class="col-md-6 col-xs-6">Specialty</div>
                                <div class="col-md-6 col-xs-6"><span><?= $model->specialtyNames ?></span></div>
                            </li>
                            <li class="row">
                                <div class="col-md-6 col-xs-6">Benefits</div>
                                <div class="col-md-6 col-xs-6"><span><?= $model->benefitsNames ?></span></div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="jobButtons"> 
                <a href="javascript:void(0)" id="submit" class="btn apply"><i class="fa fa-cc-stripe" aria-hidden="true"></i> Pay Now <?= "$" . $model->price ?></a> 
            </div>
        </div>
    </div>
</div>
<?php
$secret_id = base64_encode($model->id);
$checkoutSessionUrl = Url::to(['payment/checkoutsession', 'id' => $secret_id]);
$stripeKeyUrl = Url::to(['payment/stripekey']);
$script_new = <<<JS
    var stripe;
    var checkoutSessionId;
    "use strict";
    var setupElements = function () {
        fetch("$stripeKeyUrl", {
            method: "GET",
            headers: {
                "Content-Type": "application/json"
            }
        })
                .then(function (result) {

                    return result.json();
                })
                .then(function (data) {
                    stripe = Stripe(data.publicKey);

                });
    };

    function createCheckoutSession() {
        $.ajax({
            url:"$checkoutSessionUrl",
            type: "post", //request type,
            dataType: 'json',
            data: "",
            success: function (result) {
                checkoutSessionId = result.checkoutSessionId;
                 console.log(result.checkoutSessionId);
            }
        });
    }

    setupElements();
    document.querySelector("#submit").addEventListener("click", function (evt) {
        evt.preventDefault();
        createCheckoutSession();
        if(checkoutSessionId!=''){
        // Initiate payment
        stripe.redirectToCheckout({
                    sessionId: checkoutSessionId
                }).then(function (result) {
                    alert(result.error.message);
                    console.log("error");
                    // If `redirectToCheckout` fails due to a browser or network
                    // error, display the localized error message to your customer
                    // using `result.error.message`.
                }).catch(function (err) {
                    console.log(err);
                    alert(err);
                });
        }
    });
JS;
$this->registerJS($script_new);
