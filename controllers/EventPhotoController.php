<?php

namespace app\controllers;

use app\models\EventPhoto;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class EventPhotoController extends Controller
{

    /**
     * @param integer $id
     * @throws NotFoundHttpException
     * @throws \Throwable
     * @throws NotFoundHttpException if the model cannot be found
     * @return mixed
     */
    public function actionDelete($id)
    {
        $eventPhoto = $this->findModel($id);
        $eventPhoto->delete();
        return $this->redirect(["/events/$eventPhoto->eventId/update"]);
    }

    /**
     * @param $id
     * @return EventPhoto|null
     * @throws NotFoundHttpException
     */
    protected function findModel($id)
    {
        if (($model = EventPhoto::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}