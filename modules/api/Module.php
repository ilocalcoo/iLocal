<?php

namespace app\modules\api;

use Yii;

/**
 * api module definition class
 */
class Module extends \yii\base\Module
{
    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'app\modules\api\controllers';

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();

        // custom initialization code goes here

        // Отключаем сессии для авторизации через апи.
        // Отключаем здесь а не в конфиге, чтобы обычная авторизация через веб не отвалилась.
        Yii::$app->user->enableSession = false;
    }
}
