<?php

namespace app\assets;

use yii\web\AssetBundle;

class ProfileMapsAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/profile_map.css',
    ];
    public $js = [
        'https://api-maps.yandex.ru/2.1/?lang=ru_RU&apikey=e44f02d7-5ab4-4a5b-a382-ca2665e3825e',
        'js/event_reverse_geocode.js',
    ];
    public $jsOptions = ['position' => \yii\web\View::POS_HEAD];
    public $depends = [
    ];
}
