<?php


namespace app\modules\api\controllers;


use app\models\EventPhoto;
use app\models\HappeningPhoto;
use app\models\ShopPhoto;
use app\models\ThumbGenerator;
use Yii;
use yii\filters\auth\HttpBasicAuth;
use yii\rest\ActiveController;
use yii\web\ServerErrorHttpException;

class ImageController extends ActiveController
{
    public $modelClass = 'app\models\ThumbGenerator';

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        // Добавляем атунтификацию через BasicAuth. Токен доступа отправляется как имя пользователя.
        $behaviors['authenticator'] = [
            'class' => HttpBasicAuth::className(),
            // Отключаем аутентификацию при запросе магазинов через GET.
//            'except' => ['index', 'view','regenerate'],
            'except' => ['index', 'view'],
        ];
        return $behaviors;
    }

    public function actions()
    {
        $actions = parent::actions();
        unset($actions['create']);
        unset($actions['index']);
        return $actions;
    }

    public function actionIndex() {
        return array_merge(ShopPhoto::find()->all(), EventPhoto::find()->all(), HappeningPhoto::find()->all());
    }

    public function actionRegenerate() {
        if (!Yii::$app->request->isPost) {
            throw new ServerErrorHttpException('Bad request.');
        }
        $result = [];
        set_time_limit(600);
        $items = ['Shop', 'Event', 'Happening'];
        foreach ($items as $item) {
            $result[$item] = $this->format($item);
        }
        return $result;
    }

    private function format($item) {
        $result = [];
        $photoDir = strtolower($item).'Photo';
        $className = '\app\models\\'.$item.'Photo';
        $photos = $className::find()->all();
        foreach ($photos as $photo) {
            $fileName = 'img/'.$photoDir.'/' . $photo[$photoDir];
            $result[] = file_exists($fileName)
                ? 'regenerate '.(
                    ThumbGenerator::generate($fileName, $photo[strtolower($item).'Id'])
                        ? $photo[strtolower($item).'Id'].' '.$fileName
                        : 'error generating thumb '.$fileName
                )
                : 'no file '.$photo[strtolower($item).'Id'].' '.$fileName;
//            $result[] = ['filename'=>$fileName, 'itemId'=>$photo[strtolower($item).'Id']];
        }

        return $result;
    }
}