<?php


namespace app\modules\api\controllers;

use app\components\traits\HeaderHelper;
use app\models\Happening;
use Yii;
use yii\data\Pagination;
use yii\filters\auth\HttpBasicAuth;
use yii\rest\ActiveController;
use yii\web\ServerErrorHttpException;
use yii\web\UploadedFile;

class HappeningController extends ActiveController
{
    use HeaderHelper;

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
        unset($actions['index']);
        unset($actions['create']);
        unset($actions['update']);
        unset($actions['delete']);
        return $actions;
    }

    public function actionIndex()
    {
        $query = Happening::find()->where(['active' => 1]);
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

        return $model;
    }

    /**
     * @param $id
     * @return Happening|null
     * @throws ServerErrorHttpException
     * @throws \yii\base\InvalidConfigException
     */
    public function actionUpdate($id)
    {
        $model = Happening::findOne(['id' => $id]);
        if ($model->load(Yii::$app->getRequest()->getBodyParams(), '')) {
            if ($model->save()) {
                $model->uploadedHappeningPhoto = UploadedFile::getInstancesByName('files');
                $model->uploadHappeningPhoto();
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
        $model = Happening::findOne(['id' => $id]);
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