<?php


namespace app\assets;


use yii\web\AssetBundle;
/**
 * Main page application asset bundle.
 */
class BusinessAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/user/business.css',
    ];
    public $js = [
    ];
    public $depends = [
        'app\assets\AppAsset',
        'yii\web\YiiAsset',
        'yii\bootstrap4\BootstrapAsset',
    ];
}