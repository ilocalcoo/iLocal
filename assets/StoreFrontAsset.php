<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\assets;

use yii\web\AssetBundle;

/**
 * StoreFront asset bundle.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class StoreFrontAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/shop/view.css',
        'css/event/view.css',
    ];
    public $js = [
        'https://api-maps.yandex.ru/2.1/?apikey=e44f02d7-5ab4-4a5b-a382-ca2665e3825e&lang=ru_RU',
        'js/eventsView.js',
        'js/modal_map.js',
    ];
    public $depends = [

    ];
}
