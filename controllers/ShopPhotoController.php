<?php

namespace app\controllers;

use app\models\ShopPhoto;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class ShopPhotoController extends Controller
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
        $shopPhoto = $this->findModel($id);
        $shopPhoto->delete();
        return $this->redirect(["/shops/$shopPhoto->shopId/update/photo"]);
    }

    /**
     * @param $id
     * @return ShopPhoto|null
     * @throws NotFoundHttpException
     */
    protected function findModel($id)
    {
        if (($model = ShopPhoto::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}