<?php


namespace app\modules\api\controllers;

use app\models\Event;
use Yii;
use yii\filters\auth\HttpBasicAuth;
use yii\rest\ActiveController;
use yii\web\ServerErrorHttpException;
use yii\web\UploadedFile;

class EventController extends ActiveController
{
    public $modelClass = 'app\models\Event';

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
     * @return Event
     * @var $model Event
     */
    public function actionCreate()
    {
        $model = new Event();
        if ($model->load(Yii::$app->getRequest()->getBodyParams(), '')) {
            if ($model->save()) {
                $model->uploadedEventPhoto = UploadedFile::getInstancesByName('files');
                $model->uploadEventPhoto();
                return $model;
            } elseif (!$model->hasErrors()) {
                throw new ServerErrorHttpException('Failed to create the object for unknown reason.');
            }
        }
    }

}