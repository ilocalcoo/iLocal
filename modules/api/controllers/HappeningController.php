<?php


namespace app\modules\api\controllers;

use app\models\Happening;
use Yii;
use yii\filters\auth\HttpBasicAuth;
use yii\rest\ActiveController;
use yii\web\ServerErrorHttpException;
use yii\web\UploadedFile;

class HappeningController extends ActiveController
{
    public $modelClass = 'app\models\Happening';

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
     * @return Happening
     * @var $model Happening
     */
    public function actionCreate()
    {
        $model = new Happening();
        if ($model->load(Yii::$app->getRequest()->getBodyParams(), '')) {
            if ($model->save()) {
                $model->uploadedHappeningPhoto = UploadedFile::getInstancesByName('files');
                $model->uploadHappeningPhoto();
                return $model;
            } elseif (!$model->hasErrors()) {
                throw new ServerErrorHttpException('Failed to create the object for unknown reason.');
            }
        }
    }

}