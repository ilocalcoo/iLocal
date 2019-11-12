<?php


namespace app\modules\api\controllers;


use app\models\HappeningPhoto;
use app\models\ThumbGenerator;
use Yii;
use yii\filters\auth\HttpBasicAuth;
use yii\rest\ActiveController;

class HappeningphotoController extends ActiveController
{
    public $modelClass = 'app\models\HappeningPhoto';

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
        unset($actions['update']);
        unset($actions['delete']);
        return $actions;
    }

    public function actionDelete($id) {
        $model = HappeningPhoto::findOne(['id' => $id]);
        $fileName = $model->happeningPhoto;
        $itemId = $model->happeningId;
        if ($model->delete() === false) {
            throw new ServerErrorHttpException('Failed to delete the object for unknown reason.');
        }
        ThumbGenerator::deleteFile('happening', $itemId, $fileName);

        Yii::$app->getResponse()->setStatusCode(204);
    }

}