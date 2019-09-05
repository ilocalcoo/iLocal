<?php

namespace app\controllers;

use app\models\Event;
use app\models\Happening;
use app\models\Shop;
use app\models\User;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;

class UserController extends Controller
{
  /**
   * {@inheritdoc}
   */
  public function behaviors()
  {
    return [
      'access' => [
        'class' => AccessControl::className(),
        'rules' => [
          [
            'allow' => false,
            'actions' => ['business'],
            'roles' => ['?'],
          ],
          [
            'allow' => true,
            'roles' => ['@'],
          ],
        ],
      ],
    ];
  }

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

    $userHappenings = Happening::find()
      ->where(['=', 'creatorId', Yii::$app->user->id])
      ->joinWith(Happening::RELATION_HAPPENING_PHOTOS)
      ->asArray()
      ->all();

    return $this->render('business', [
      'userShops' => $userShops,
      'userEvents' => $userEvents,
      'userHappenings' => $userHappenings,
    ]);
  }
}