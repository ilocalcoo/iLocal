<?php


namespace app\modules\api\controllers;

use app\components\traits\HeaderHelper;
use app\models\Event;
use Yii;
use yii\data\Pagination;
use yii\filters\auth\HttpBasicAuth;
use yii\rest\ActiveController;
use yii\web\ServerErrorHttpException;
use yii\web\UploadedFile;

class EventController extends ActiveController
{
    use HeaderHelper;
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
        unset($actions['index']);
        unset($actions['create']);
        unset($actions['update']);
        unset($actions['delete']);
        return $actions;
    }

    public function actionIndex()
    {
        $query = Event::find()->where(['active' => 1]);
        $pages = new Pagination([
            'totalCount' => $query->count(),
            'pageSize' => Yii::$app->request->get('per-page') ?? 3,
        ]);
        $this->setPaginationHeaders($pages);
        $query = $query->offset($pages->offset)
            ->limit($pages->limit);

        return array_values($query->all());
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

    /**
     * @return Event
     * @var $model Event
     */
    public function actionUpdate($id)
    {
        $model = Event::findOne(['id' => $id]);
        if ($model->load(Yii::$app->getRequest()->getBodyParams(), '')) {
            if ($model->save()) {
                $model->uploadedEventPhoto = UploadedFile::getInstancesByName('files');
                $model->uploadEventPhoto();
                return $model;
            } elseif (!$model->hasErrors()) {
                throw new ServerErrorHttpException('Failed to create the object for unknown reason.');
            }
        }

        return $model;
    }

    /**
     * @param $id
     * @return bool
     * @throws ServerErrorHttpException
     */
    public function actionDelete($id)
    {
        $model = Event::findOne(['id' => $id]);
        if ($model) {
            $model->active = 0;
            if ($model->save()) {
                return true;
            } elseif (!$model->hasErrors()) {
                throw new ServerErrorHttpException('Failed to delete the object for unknown reason.');
            }
        }

        return false;
    }

}