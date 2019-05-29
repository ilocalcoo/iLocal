<?php
defined('YII_DEBUG') or define('YII_DEBUG', true);
// если выкладываем на heroku, то переключаем dev среду на prod
if (! ($_SERVER['SERVER_NAME'] == "morning-island-64245.herokuapp.com")) {
//    defined('YII_DEBUG') or define('YII_DEBUG', true);
    defined('YII_ENV') or define('YII_ENV', 'dev');
}

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../vendor/yiisoft/yii2/Yii.php';

$config = require __DIR__ . '/../config/web.php';

(new yii\web\Application($config))->run();
