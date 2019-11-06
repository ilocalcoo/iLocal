<?php

namespace app\controllers;

use app\models\EventPhoto;
use app\models\HappeningPhoto;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class HappeningPhotoController extends Controller
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
        $happeningPhoto = $this->findModel($id);
        $happeningPhoto->delete();
        return $this->redirect(["/happenings/$happeningPhoto->happeningId/update"]);
    }

    /**
     * @param $id
     * @return HappeningPhoto|null
     * @throws NotFoundHttpException
     */
    protected function findModel($id)
    {
        if (($model = HappeningPhoto::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}