<?php

namespace app\controllers;

use app\models\Event;
use app\models\ShopAddress;
use app\models\ShopRating;
use app\models\UserEvent;
use app\models\UserShop;
use Yii;
use app\models\Shop;
use app\models\search\ShopSearch;
use yii\data\Pagination;
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
        if (Yii::$app->request->get('add-shop-id') || $shopId = Yii::$app->request->get('del-shop-id')) {
            if (!Yii::$app->user->isGuest) {
                if ($shopId = Yii::$app->request->get('add-shop-id')) {
                    $userShop = new UserShop();
                    $userShop->user_id = Yii::$app->user->id;
                    $userShop->shop_id = $shopId;
                    $userShop->save();
                }

                if ($shopId = Yii::$app->request->get('del-shop-id')) {
                    $userShop = UserShop::find()
                        ->where(['user_id' => Yii::$app->user->id])
                        ->andWhere(['shop_id' => $shopId])
                        ->one();
                    $userShop->delete();
                }

                $query = Shop::find()->where(['shopActive' => 1]);
                if (array_key_exists('shopTypeId', Yii::$app->request->queryParams)) {
                    $query = $query->where(
                        ['shopTypeId' => Yii::$app->request->queryParams['shopTypeId']]
                    );
                }
            } else {
                Yii::$app->getSession()->setFlash('error', 'Войдите, чтобы добавлять в избранное!');
                //TODO уведомление
            }
        }

        $query = Shop::find()->where(['shopActive' => 1]);
        if (array_key_exists('shopTypeId', Yii::$app->request->queryParams)) {
            $query = $query->where(
                ['shopTypeId' => Yii::$app->request->queryParams['shopTypeId']]
            );
        }
        $pages = new Pagination([
            'totalCount' => $query->count(),
            'pageSize' => 4,
        ]);
        $shops = $query->offset($pages->offset)
            ->limit($pages->limit)
            ->all();
        return $this->render('index', [
            'shops' => $shops,
            'pages' => $pages,
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
        if ($shopId = Yii::$app->request->get('add-shop-id')) {
            $userShop = new UserShop();
            $userShop->user_id = Yii::$app->user->id;
            $userShop->shop_id = $shopId;
            $userShop->save();
        }

        if ($shopId = Yii::$app->request->get('del-shop-id')) {
            $userShop = UserShop::find()
                ->where(['user_id' => Yii::$app->user->id])
                ->andWhere(['shop_id' => $shopId])
                ->one();
            $userShop->delete();
        }

        if ($eventId = Yii::$app->request->get('add-event-id')) {
            $userEvent = new UserEvent();
            $userEvent->user_id = Yii::$app->user->id;
            $userEvent->event_id = $eventId;
            $userEvent->save();
        }

        if ($eventId = Yii::$app->request->get('del-event-id')) {
            $userEvent = UserEvent::find()
                ->where(['user_id' => Yii::$app->user->id])
                ->andWhere(['event_id' => $eventId])
                ->one();
            $userEvent->delete();
        }

        $shopEvents = Event::find()
            ->where(['eventOwnerId' => $id])
            ->all();

        return $this->render('view', [
            'model' => $this->findModel($id),
            'shopEvents' => $shopEvents,
        ]);
    }

    /**
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException
     */
    public function actionCreateStep1()
    {
        $id = Yii::$app->request->get('id');
        $setFlash = false;

        if (isset($id)) {
            $model = $this->findModel($id);
        } else {
            $model = new Shop();
            $setFlash = true;
        }

        $model->setScenario(Shop::SCENARIO_STEP1);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            if ($setFlash) {
                Yii::$app->session->setFlash('success', 'Магазин: "' . $model->shopShortName . '" успешно добавлен.
                Вы можете продолжить заполнение информации о магазине сейчас, либо позже.');
            }
            return $this->redirect(["/shops/$model->shopId/update/photo"]);
        }
        return $this->render('create/step-1', [
            'model' => $model,
        ]);
    }

    /**
     * @param $id
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException
     */
    public function actionCreateStep2($id)
    {
        $model = $this->findModel($id);
        $model->setScenario(Shop::SCENARIO_STEP2);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $model->uploadedShopPhoto = UploadedFile::getInstances($model, 'uploadedShopPhoto');

            if ($model->uploadShopPhoto()) {
                return $this->refresh();
            }
        }
        return $this->render('create/step-2', [
            'model' => $model,
        ]);
    }

    /**
     * @param $id
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException
     */
    public function actionCreateStep3($id)
    {
        $model = $this->findModel($id);
        $model->setScenario(Shop::SCENARIO_STEP3);

        $shopAddress = ShopAddress::findOne($model->shopAddressId);
        if (($shopAddress) === null) {
            $shopAddress = new ShopAddress();
        }



        if (Yii::$app->request->post('address')) {
            $addressArray = explode(',', Yii::$app->request->post('address'));

            if (!$addressArray[0]) {
                Yii::$app->getSession()->setFlash('error', 'Не выбран город');
                return $this->refresh();
            }
            if (!$addressArray[1]) {
                Yii::$app->getSession()->setFlash('error', 'Не выбрана улица');
                return $this->refresh();
            }
            if (!$addressArray[2]) {
                Yii::$app->getSession()->setFlash('error', 'Не выбран дом');
                return $this->refresh();
            }

            if ($model->shopAddress) {
                $modelAddress = $model->shopAddress;
            } else {
                $modelAddress = new ShopAddress();
            }


            $modelAddress->city = $addressArray[0];
            $modelAddress->street = $addressArray[1];
            $modelAddress->houseNumber = $addressArray[2];
            $modelAddress->latitude = $addressArray[3];
            $modelAddress->longitude = $addressArray[4];

            if ($modelAddress->save()) {
                $model->shopAddressId = $modelAddress->id;
                $model->save();
                Yii::$app->getSession()->setFlash('success', 'Адрес сохранен');
                return $this->refresh();
            }

        }




//        if ($shopAddress->load(Yii::$app->request->post()) && $shopAddress->save()) {
//            $model->shopAddressId = $shopAddress->id;
//            if ($model->load(Yii::$app->request->post()) && $model->save()) {
//                return $this->redirect(["/shops/$model->shopId/update/prices"]);
//            }
//        }

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            if ($model->shopAddressId) {
                return $this->redirect(["/shops/$model->shopId/update/prices"]);
            } else {
                Yii::$app->getSession()->setFlash('error', 'Адрес не выбран!');
            }
        }

        return $this->render('create/step-3', [
            'model' => $model,
            'shopAddress' => $shopAddress,
        ]);
    }

    /**
     * @param $id
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException
     */
    public function actionCreateStep4($id)
    {
        $model = $this->findModel($id);
        $model->setScenario(Shop::SCENARIO_STEP4);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['user/business']);
        }

        return $this->render('create/step-4', [
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
        $shop->setScenario(Shop::SCENARIO_RATING);

        if ($shop->shopRating()) {
            return true;
        }
        echo 'false';
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
        $model->setScenario(Shop::SCENARIO_DEFAULT);
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
