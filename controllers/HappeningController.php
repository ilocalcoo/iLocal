<?php

namespace app\controllers;

//use app\models\search\HappeningSearch;
use app\models\Shop;
use app\models\User;
use app\models\UserHappening;
use DateTime;
use Yii;
use app\models\Happening;
use yii\data\Pagination;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

/**
 * HappeningController implements the CRUD actions for Happening model.
 */
class HappeningController extends Controller
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
      'access' => [
        'class' => AccessControl::className(),
        'rules' => [
          [
            'allow' => true,
            'actions' => ['index', 'view'],
            'roles' => ['?'],
          ],
          [
            'allow' => true,
            'roles' => ['@'],
          ],
        ],
      ],
    ];
  }

  /**
   * Lists all Happening models.
   * @return mixed
   */
  public function actionIndex()
  {
    if ($happeningId = Yii::$app->request->get('add-id')) {
      $userHappening = new UserHappening();
      $userHappening->userId = Yii::$app->user->id;
      $userHappening->userId = $happeningId;
      $userHappening->save();
    }

    if ($happeningId = Yii::$app->request->get('del-id')) {
      $userHappening = UserHappening::find()
        ->where(['userId' => Yii::$app->user->id])
        ->andWhere(['happeningId' => $happeningId])
        ->one();
      $userHappening->delete();
    }

//        $searchModel = new HappeningSearch();
//        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
//
//        $shortDescData = Happening::find()
//            ->select(['shortDesc as value', 'shortDesc as label', 'id as id'])
//            ->asArray()
//            ->all();
//
//        return $this->render('index', [
//            'searchModel' => $searchModel,
//            'dataProvider' => $dataProvider,
//            'shortDescData' => $shortDescData,
//        ]);

//        $query = Shop::find()->where(['shopActive' => 1])->where(['shopId' => Happening::find()->select('eventOwnerId')]);
//        if (array_key_exists('eventTypeId', Yii::$app->request->queryParams)) {
//            $query = $query->having(
//                ['shopTypeId' => Yii::$app->request->queryParams['eventTypeId']]
//            );
//        }
    $query = Happening::find()->joinWith('shop')->cache(10);
      if (array_key_exists('happeningTypeId', Yii::$app->request->queryParams)) {
          $query = $query->where(
              ['happeningTypeId' => Yii::$app->request->queryParams['happeningTypeId']]
          );
      }
    $pages = new Pagination([
      'totalCount' => $query->count(),
      'pageSize' => 10,
    ]);
    $happenings = $query->offset($pages->offset)
      ->limit($pages->limit)
      ->all();
    return $this->render('index', [
      'happenings' => $happenings,
      'pages' => $pages,
    ]);
  }

  /**
   * Displays a single Happening model.
   * @param integer $id
   * @return mixed
   * @throws NotFoundHttpException if the model cannot be found
   */
  public function actionView($id)
  {
      if (!Yii::$app->user->isGuest) {
          if ($happeningId = Yii::$app->request->get('add-id')) {
              $userHappening = new UserHappening();
              $userHappening->userId = Yii::$app->user->id;
              $userHappening->userId = $happeningId;
              $userHappening->save();
          }

          if ($happeningId = Yii::$app->request->get('del-id')) {
              $userHappening = UserHappening::find()
                  ->where(['userId' => Yii::$app->user->id])
                  ->andWhere(['happeningId' => $happeningId])
                  ->one();
              $userHappening->delete();
          }
      }

      return $this->render('view', [
          'model' => $this->findModel($id),
      ]);
  }

  /**
   * Creates a new Happening model.
   * If creation is successful, the browser will be redirected to the 'view' page.
   * @return mixed
   */
  public function actionCreate()
  {
    $model = new Happening();
    if (Yii::$app->request->get('id')) {
      $model = $this->findModel((Yii::$app->request->get('id')));
    }
    if (Yii::$app->request->post('input_address')) {
      $model->address = Yii::$app->request->post('input_address');
    }

    if ($model->load(Yii::$app->request->post())) {
        if (Yii::$app->request->post('coords_address')) {
            $coords = explode(',',Yii::$app->request->post('coords_address'));
            $model->latitude = $coords[0] ?? '';
            $model->longitude = $coords[1] ?? '';
        }
        if ($model->save()) {
            $model->uploadedHappeningPhoto = UploadedFile::getInstances($model, 'uploadedHappeningPhoto');
            $model->uploadHappeningPhoto();

            return $this->redirect(['view', 'id' => $model->id]);
        }
    }

    return $this->render('create', [
      'model' => $model,
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
      $model = new Happening();
      $setFlash = true;
    }

    $eventOwner = Shop::find()
      ->select('shopShortName')
      ->where(['=', 'creatorId', Yii::$app->user->id])
      ->indexBy('shopId')
      ->column();

    $model->setScenario(Happening::SCENARIO_STEP1);

    if ($model->load(Yii::$app->request->post()) && $model->save()) {
      if ($setFlash) {
        Yii::$app->session->setFlash('success', 'Акция успешно добавлена.
                Вы можете продолжить заполнение информации о акции сейчас, либо позже.');
      }
      return $this->redirect(["/happenings/$model->id/update/info"]);
    }

    return $this->render('create/step-1', [
      'model' => $model,
      'eventOwner' => $eventOwner,
      'userId' => Yii::$app->user->id,
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
    $model->setScenario(Happening::SCENARIO_STEP2);

    if ($model->load(Yii::$app->request->post()) && $model->save()) {
      return $this->redirect(["/happenings/$model->id/update/photo"]);
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
    $model->setScenario(Happening::SCENARIO_STEP3);

    if ($model->load(Yii::$app->request->post()) && $model->save()) {
      $model->uploadedHappeningPhoto = UploadedFile::getInstances($model, 'uploadedHappeningPhoto');

      if ($model->uploadHappeningPhoto()) {
          return $this->refresh();
      }
    }
    return $this->render('create/step-3', [
      'model' => $model,
    ]);
  }

  /**
   * Updates an existing Happening model.
   * If update is successful, the browser will be redirected to the 'view' page.
   * @param integer $id
   * @return mixed
   * @throws NotFoundHttpException if the model cannot be found
   */
  public function actionUpdate($id)
  {
    $model = $this->findModel($id);

    if (Yii::$app->request->isPost) {
      $model->uploadedHappeningPhoto = UploadedFile::getInstances($model, 'uploadedHappeningPhoto');

      if ($model->uploadHappeningPhoto()) {
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
          return $this->redirect(['view', 'id' => $model->id]);
        }
      }
    }

    return $this->render('update', [
      'model' => $model,
    ]);
  }

  /**
   * Disactivate an existing Happening model.
   * If disactivation is successful, the browser will be redirected to the 'index' page.
   * @param integer $id
   * @return mixed
   * @throws NotFoundHttpException if the model cannot be found
   */
  public function actionDelete($id)
  {
    $model = $this->findModel($id);
    $model->setScenario(Happening::SCENARIO_DEFAULT);
    $model->active = Happening::STATUS_DISABLE;
    if ($model->save()) {
      return $this->redirect(['view', 'id' => $model->id]);
    }
    return $this->redirect(['index']);
  }

  /**
   * Finds the Happening model based on its primary key value.
   * If the model is not found, a 404 HTTP exception will be thrown.
   * @param integer $id
   * @return Happening the loaded model
   * @throws NotFoundHttpException if the model cannot be found
   */
  protected function findModel($id)
  {
    if (($model = Happening::findOne($id)) !== null) {
      return $model;
    }

    throw new NotFoundHttpException('The requested page does not exist.');
  }
}
