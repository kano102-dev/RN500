<?php

namespace common\widgets;

use Yii;
use yii\helpers\ArrayHelper;
use yii\bootstrap\Html;
use yii\bootstrap\BootstrapAsset;
use yii\bootstrap\BootstrapPluginAsset;

class LBRightPopup extends \yii\bootstrap\Widget {

    public $options = [];
    public $topActionBarContent = "";
    public $bottomActionBarContent = "";
    public $contentOptions = [];

    public function init() {
        parent::init();
        $popupOptions = $this->options;
        if (!isset($popupOptions['class'])) {
            Html::addCssClass($popupOptions, 'right-sidebar');
        }
        echo Html::beginTag('div', $popupOptions) . "\n";

//        $dismissOnclick = "$("#sidebar").LBRightPopup("hide")";
        if (!empty($this->topActionBarContent)) {
            echo Html::tag('div', $this->topActionBarContent , ['class' => 'row top-rs-action-bar']);
        }

        $contentOptions = $this->contentOptions;
//        if (isset($contentOptions['class'])) {
//            
//        }

        Html::addCssClass($contentOptions, 'rs-content');
        echo Html::beginTag('div', $contentOptions) . "\n";
    }

    public function run() {
        echo Html::endTag('div');
        if (!empty($this->bottomActionBarContent)) {
            echo Html::tag('div', $this->bottomActionBarContent, ['class' => 'bottom-rs-action-bar']);
        }
        echo Html::endTag('div');
    }
}
