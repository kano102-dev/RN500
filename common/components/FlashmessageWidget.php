<?php

namespace common\components;

use yii;
use yii\base\Widget;

class FlashmessageWidget extends Widget {

    public function run() {
        return $this->render("flashMessageWidgetView");
    }

}

?>
