<?php


namespace app\assets;


use yii\web\AssetBundle;

class CreateAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/create.css',
    ];
    public $js = [
    ];
    public $depends = [
        'app\assets\AppAsset',
        'yii\web\YiiAsset',
        'yii\bootstrap4\BootstrapAsset',
    ];
}