<?php

namespace app\controllers;

use app\models\Event;
use app\models\Shop;
use app\models\User;
use Yii;
use yii\web\Controller;

class UserController extends Controller
{
    /**
     * @return string
     */
    public function actionBusiness()
    {
        $userShops = Shop::find()
            ->where(['=', 'creatorId', Yii::$app->user->id])
            ->joinWith(Shop::RELATION_SHOP_PHOTOS)
            ->asArray()
            ->all();

        $userEvents = Event::find()
            ->where(['=', 'creatorId', Yii::$app->user->id])
            ->joinWith(Event::RELATION_EVENT_PHOTOS)
            ->asArray()
            ->all();

        return $this->render('business', [
            'userShops' => $userShops,
            'userEvents' => $userEvents
        ]);
    }
}