<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\assets;

use yii\web\AssetBundle;

/**
 * Event asset bundle.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class EventFeedAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/event.css',
        'css/event/view.css',
    ];
    public $js = [
        'js/eventsView.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'app\assets\AppAsset',
    ];
}
