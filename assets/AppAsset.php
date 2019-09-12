<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\assets;

use yii\web\AssetBundle;

/**
 * Main application asset bundle.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        '//fonts.googleapis.com/css?family=Roboto:400,700&display=swap',
        'https://use.fontawesome.com/releases/v5.8.2/css/all.css',
        'css/contactForm.css',
        'css/fonts.css',
        'css/site.css',
        'css/style.css',
        'css/mainBootstrap.css',
        'css/slider.css',
    ];
    public $js = [
        'js/imageUploaded.js',
        '/js/contactForm.js',
        '/js/header.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap4\BootstrapAsset',
    ];
}
