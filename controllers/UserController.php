<?php

namespace app\controllers;

use app\models\Event;
use app\models\Happening;
use app\models\Shop;
use app\models\User;
use app\models\UserAddress;
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
        'title' => 'I\'m Local - Бизнесу'
    ]);
  }

  public function actionProfile() {
      $model = User::find()->where(['=', 'id', Yii::$app->user->id])->one();

      if (Yii::$app->request->post('input_address') && Yii::$app->request->post('coords_address')) {
          $addressArray = explode(',', Yii::$app->request->post('input_address'));

          if (!$addressArray[0]) {
              Yii::$app->getSession()->setFlash('error', 'Не выбран город');
              return $this->refresh();
          }
          if (!$addressArray[1]) {
              Yii::$app->getSession()->setFlash('error', 'Не выбрана улица');
              return $this->refresh();
          }
          if (!$addressArray[2]) {
              Yii::$app->getSession()->setFlash('error', 'Не выбран дом');
              return $this->refresh();
          }

          $coordsArray = explode(',', Yii::$app->request->post('coords_address'));


          if (!$model->userAddress) {
              $model->userAddress = new UserAddress();
          }

          $model->userAddress->city = $addressArray[0];
          $model->userAddress->street = $addressArray[1];
          $model->userAddress->houseNumber = $addressArray[2];
          $model->userAddress->latitude = $coordsArray[0] ?? '';
          $model->userAddress->longitude = $coordsArray[1] ?? '';
          if ($model->userAddress->save()) {
              $model->userAddressId = $model->userAddress->id;
              $model->save();
          }
      }
      if ($model->load(Yii::$app->request->post())) {
          $model->save();
      }

      return $this->render('profile', [
          'model' => $model,
          'title' => 'I\'m Local - Пользователь'
      ]);
  }

}