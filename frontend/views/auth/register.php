<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
?>
<div class="listpgWraper">
    <div class="container">
        <div class="row">
            <div class="col-md-6 col-md-offset-3">
                <div class="userccount">
                    <div class="userbtns">
                        <ul class="nav nav-tabs">
                            <li class="active"><a data-toggle="tab" href="#candidate">Candidate</a></li>
                            <li><a data-toggle="tab" href="#employer">Employer</a></li>
                        </ul>
                    </div>
                    <div class="tab-content">
                        <div id="candidate" class="formpanel tab-pane fade in active">
                            <div class="formrow">
                                <input type="text" name="name" class="form-control" placeholder="Full Name">
                            </div>
                            <div class="formrow">
                                <input type="text" name="username" class="form-control" placeholder="Username">
                            </div>
                            <div class="formrow">
                                <input type="text" name="email" class="form-control" placeholder="Email">
                            </div>
                            <div class="formrow">
                                <input type="text" name="password" class="form-control" placeholder="Password">
                            </div>
                            <div class="formrow">
                                <input type="text" name="conpass" class="form-control" placeholder="Confirm Password">
                            </div>
                            <div class="formrow">
                                <input type="checkbox" value="agree text" name="agree" />
                                There are many variations of passages of Lorem Ipsum available</div>
                            <input type="submit" class="btn" value="Register">
                        </div>
                        <div id="employer" class="formpanel tab-pane fade in">
                            <div class="formrow">
                                <input type="text" name="cname" class="form-control" placeholder="Company Name">
                            </div>
                            <div class="formrow">
                                <input type="text" name="cusername" class="form-control" placeholder="Username">
                            </div>
                            <div class="formrow">
                                <input type="text" name="cemail" class="form-control" placeholder="Email">
                            </div>
                            <div class="formrow">
                                <input type="text" name="cpass" class="form-control" placeholder="Password">
                            </div>
                            <div class="formrow">
                                <input type="text" name="cpass" class="form-control" placeholder="Confirm Password">
                            </div>
                            <div class="formrow">
                                <input type="checkbox" value="agree text c" name="cagree" />
                                There are many variations of passages of Lorem Ipsum available</div>
                            <input type="submit" class="btn" value="Register">
                        </div>
                    </div>
                    <div class="newuser"><i class="fa fa-user" aria-hidden="true"></i> Already a Member? <a href="<?= Yii::$app->urlManager->createUrl('auth/login'); ?>">Login Here</a></div>
                </div>
            </div>
        </div>
    </div>
</div>

