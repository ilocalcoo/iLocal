<?php

namespace app\assets;

use yii\web\AssetBundle;

/**
 * Main page application asset bundle.
 */
class SliderAsset extends AssetBundle
{
  public $basePath = '@webroot';
  public $baseUrl = '@web';
  public $css = [
    'css/slider.css',
  ];
  public $js = [
    'js/slider.js',
  ];
  public $depends = [
    'app\assets\MainAsset',
  ];
}
