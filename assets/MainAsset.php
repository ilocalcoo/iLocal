<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\assets;

use yii\web\AssetBundle;

/**
 * Main page application asset bundle.
 */
class MainAsset extends AssetBundle
{
  public $basePath = '@webroot';
  public $baseUrl = '@web';
  public $css = [
    'css/main.css',
    'css/slider.css',
  ];
  public $js = [
    'js/slider.js',
  ];
  public $depends = [
    'app\assets\AppAsset',
    'yii\web\YiiAsset',
    'yii\bootstrap4\BootstrapAsset',
  ];
}
