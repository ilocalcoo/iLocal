<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\assets;

use yii\web\AssetBundle;

/**
 * Shop asset bundle.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class ShopFeedAsset extends AssetBundle
{
  public $basePath = '@webroot';
  public $baseUrl = '@web';
  public $css = [
    'css/shop.css'
  ];
  public $js = [
    'js/shop_feed.js',
  ];
  public $jsOptions = ['position' => \yii\web\View::POS_HEAD];
  public $depends = [
    'app\assets\AppAsset',
  ];
}
