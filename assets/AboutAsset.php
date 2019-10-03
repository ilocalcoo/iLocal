<?php

namespace app\assets;

use yii\web\AssetBundle;

/**
 * Main page application asset bundle.
 */
class AboutAsset extends AssetBundle
{
  public $basePath = '@webroot';
  public $baseUrl = '@web';
  public $css = [
    'css/about.css',
  ];
  public $js = [
  ];
  public $depends = [
    'app\assets\MainAsset',
  ];
}
