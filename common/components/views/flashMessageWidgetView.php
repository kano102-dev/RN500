<?php

$type = "";
$message = "";

// SET TOASTR TYPE ACCORDING FLAH KEY & GET MSG
if (Yii::$app->session->has("success")) {
    $type = "success";
    $message = Yii::$app->session->get("success");
} else if (Yii::$app->session->has("warning")) {
    $type = "warning";
    $message = Yii::$app->session->get("warning");
} else if (Yii::$app->session->has("error")) {
    $type = "error";
    $message = Yii::$app->session->get("error");
} else if (Yii::$app->session->has("info")) {
    $type = "info";
    $message = Yii::$app->session->get("info");
}
// DISPLAY FLAH MSG IN TOASTR AND DESTROY AFTER EXECUTION
if (($type == "success" || $type == "warning" || $type == "error" || $type == "info") && $message != "") {
    $script = <<< JS
toastr.$type("","$message"); 
JS;
    $this->registerJs($script);
    Yii::$app->session->getAllFlashes(false);
}
    