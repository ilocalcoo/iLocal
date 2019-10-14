<?php


namespace app\modules\api\controllers;

use app\models\Shop;
use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\auth\HttpBasicAuth;
use yii\helpers\Url;
use yii\rest\ActiveController;
use yii\web\ServerErrorHttpException;
use yii\web\UploadedFile;

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
        unset($actions['create']);
        return $actions;
    }

    /**
     * @return Shop
     * @var $model Shop
     */
    public function actionCreate()
    {
        $model = new Shop();

        if ($model->load(Yii::$app->getRequest()->getBodyParams(), '')) {
            $model->uploadedShopPhoto = UploadedFile::getInstances($model, 'uploadedShopPhoto');
            $model->uploadShopPhoto();
            if ($model->save()) {
                return $model;
            } elseif (!$model->hasErrors()) {
                throw new ServerErrorHttpException('Failed to create the object for unknown reason.');
            }
        }
    }

}