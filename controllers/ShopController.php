<?php

namespace app\controllers;

use app\models\ShopPhoto;
use app\models\ShopRating;
use Yii;
use app\models\Shop;
use app\models\search\ShopSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

/**
 * ShopController implements the CRUD actions for Shop model.
 */
class ShopController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Shop models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ShopSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $shopShortNameData = Shop::find()
            ->select(['shopShortName as value', 'shopShortName as label', 'shopId as id'])
            ->asArray()
            ->all();

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'shopShortNameData' => $shopShortNameData,
        ]);
    }

    /**
     * Displays a single Shop model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Shop model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Shop();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $model->uploadedShopPhoto = UploadedFile::getInstances($model, 'uploadedShopPhoto');

            if ($model->uploadShopPhoto()) {
                return $this->redirect(['view', 'id' => $model->shopId]);
            }
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Shop model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if (Yii::$app->request->isPost) {
            $model->uploadedShopPhoto = UploadedFile::getInstances($model, 'uploadedShopPhoto');

            if ($model->uploadShopPhoto()) {
                if ($model->load(Yii::$app->request->post()) && $model->save()) {
                    return $this->redirect(['view', 'id' => $model->shopId]);
                }
            }
        }
        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * @return bool
     * @throws NotFoundHttpException
     */
    public function actionRating()
    {
        $findRating = ShopRating::find()->where(['shopId' => $_POST['shopId'], 'userId' => $_POST['userId']])->one();

        if (!empty($findRating)) {
            $findRating->rating = $_POST['rating'];
            $findRating->save();
        } else {
            $newRating = new ShopRating();
            $newRating->shopId = $_POST['shopId'];
            $newRating->userId = $_POST['userId'];
            $newRating->rating = $_POST['rating'];
            $newRating->save();
        }

        $shop = $this->findModel($_POST['shopId']);

        if ($shop->shopRating()) {
            return true;
        }
        return false;
    }

    /**
     * Deletes an existing Shop model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $model->shopActive = Shop::SHOP_ACTIVE_FALSE;
        if ($model->save()) {
            Yii::$app->session->setFlash('success', 'Статус магазина: "' . $model->shopShortName . '" успешно изменён');
            return $this->redirect(['view', 'id' => $model->shopId]);
        }
        return $this->redirect(['index']);
    }

    /**
     * Finds the Shop model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Shop the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Shop::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
