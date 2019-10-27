<?php


namespace app\modules\api\controllers;

use app\models\Shop;
use Yii;
use yii\data\Pagination;
use yii\filters\auth\HttpBasicAuth;
use yii\rest\ActiveController;

class ShopController extends ActiveController
{
  public $modelClass = 'app\models\Shop';

  public function behaviors()
  {
    $behaviors = parent::behaviors();
    // Добавляем атунтификацию через BasicAuth. Токен доступа отправляется как имя пользователя.
    $behaviors['authenticator'] = [
      'class' => HttpBasicAuth::className(),
      // Отключаем аутентификацию при запросе магазинов через GET.
      'except' => ['index', 'view'],
    ];
    return $behaviors;
  }

  public function actions()
  {
    $actions = parent::actions();
    unset($actions['index']);
    return $actions;
  }

  public function actionIndex()
  {
    $query = Shop::find()->where(['shopActive' => 1]);

    $pages = new Pagination([
      'totalCount' => $query->count(),
      'pageSize' => Yii::$app->request->get('per-page'),
    ]);
    $query = $query->offset($pages->offset)
      ->limit($pages->limit);

    $userPoint = explode(',', Yii::$app->request->get('userPoint'));
    $range = Yii::$app->request->get('range')*1;
    $shops = [];
    if (!is_null($userPoint) && !is_null($range) && ($userPoint !== '') && ($range !== '')) {
      if (is_int($range) && ($range > 0) && Shop::isUserPointValid($userPoint)) {
        $shops = Shop::getShopsInRange($query, $userPoint, $range);
        return $shops;
      }
    }
    return $shops;
  }

}