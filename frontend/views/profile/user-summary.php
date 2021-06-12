<?php

use yii\helpers\Html;
?>
<!-- Page Title start -->
<div class="pageTitle">
    <div class="container">
        <div class="row">
            <div class="col-md-6 col-sm-6">
                <h1 class="page-heading">Profile</h1>
            </div>
        </div>
    </div>
</div>
<!-- Page Title End -->

<div class="listpgWraper" style="background-color: white">
    <div class="container"> 
        <?= $this->render('core-profile-detail', ['model' => $model, 'workExperiences' => $workExperiences, 'certifications' => $certifications, 'documents' => $documents, 'licenses' => $licenses, 'educations' => $educations, 'references' => $references]); ?>
    </div>
</div>