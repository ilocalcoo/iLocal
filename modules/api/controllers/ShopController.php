<?php


namespace app\modules\api\controllers;

use app\components\traits\HeaderHelper;
use app\models\Shop;
use Yii;
use yii\data\Pagination;
use yii\filters\auth\HttpBasicAuth;
use yii\rest\ActiveController;
use yii\web\ServerErrorHttpException;
use yii\web\UploadedFile;

class ShopController extends ActiveController
{
  use HeaderHelper;

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
    unset($actions['create']);
    return $actions;
  }

  public function actionIndex()
  {
    $query = Shop::find()->where(['shopActive' => 1]);
    $pages = new Pagination([
      'totalCount' => $query->count(),
      'pageSize' => Yii::$app->request->get('per-page') ?? 3,
    ]);
    $this->setPaginationHeaders($pages);
    $query = $query->offset($pages->offset)
      ->limit($pages->limit);

    $userPoint = explode(',', Yii::$app->request->get('userPoint'));
    $range = Yii::$app->request->get('range') * 1;
    $shops = [];
    if (!is_null($userPoint) && !is_null($range) && ($userPoint !== '') && ($range !== '')) {
      if (is_int($range) && ($range > 0) && Shop::isUserPointValid($userPoint)) {
        $shops = Shop::getShopsInRange($query, $userPoint, $range);
      }
    }
    return array_values($shops);
  }

  /**
   * @return Shop
   * @var $model Shop
   */
  public function actionCreate()
  {
    $model = new Shop();
    if ($model->load(Yii::$app->getRequest()->getBodyParams(), '')) {
      if ($model->save()) {
        $model->uploadedShopPhoto = UploadedFile::getInstancesByName('files');
        $model->uploadShopPhoto();
        return $model;
      } elseif (!$model->hasErrors()) {
        throw new ServerErrorHttpException('Failed to create the object for unknown reason.');
      }
    }
  }

}