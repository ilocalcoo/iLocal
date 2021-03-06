<?php

namespace app\controllers;

use app\models\search\EventSearch;
use app\models\Shop;
use app\models\UserEvent;
use Yii;
use app\models\Event;
use yii\data\Pagination;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

/**
 * EventController implements the CRUD actions for Event model.
 */
class EventController extends Controller
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
   * Lists all Event models.
   * @return mixed
   */
  public function actionIndex()
  {
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
      if ($userEvent) {
          $userEvent->delete();
      }
    }

//        $searchModel = new EventSearch();
//        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
//
//        $shortDescData = Event::find()
//            ->select(['shortDesc as value', 'shortDesc as label', 'id as id'])
//            ->asArray()
//            ->all();
//
//        return $this->render('index', [
//            'searchModel' => $searchModel,
//            'dataProvider' => $dataProvider,
//            'shortDescData' => $shortDescData,
//        ]);

//        $query = Shop::find()->where(['shopActive' => 1])->where(['shopId' => Event::find()->select('eventOwnerId')]);
//        if (array_key_exists('eventTypeId', Yii::$app->request->queryParams)) {
//            $query = $query->having(
//                ['shopTypeId' => Yii::$app->request->queryParams['eventTypeId']]
//            );
//        }
    $query = Event::find()->joinWith('shop')->cache(10);
    $pages = new Pagination([
      'totalCount' => $query->count(),
      'pageSize' => 10,
    ]);
    $shops = $query->offset($pages->offset)
      ->limit($pages->limit)
      ->all();
    return $this->render('index', [
      'events' => $shops,
//            'shops' => $shops,
      'pages' => $pages,
    ]);
  }

  /**
   * Displays a single Event model.
   * @param integer $id
   * @return mixed
   * @throws NotFoundHttpException if the model cannot be found
   */
  public function actionView($id)
  {
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
          if ($userEvent) {
              $userEvent->delete();
          }
      }

    return $this->render('view', [
      'model' => $this->findModel($id),
    ]);
  }

  /**
   * Creates a new Event model.
   * If creation is successful, the browser will be redirected to the 'view' page.
   * @return mixed
   */
  public function actionCreate()
  {
      $model = new Event();
      if (Yii::$app->request->get('id')) {
          $model = $this->findModel((Yii::$app->request->get('id')));
      }

    if ($model->load(Yii::$app->request->post()) && $model->save()) {
        $model->uploadedEventPhoto = UploadedFile::getInstances($model, 'uploadedEventPhoto');
        $model->uploadEventPhoto();

        return $this->redirect(['view', 'id' => $model->id]);
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
      $model = new Event();
      $setFlash = true;
    }

    $eventOwner = Shop::find()
      ->select('shopShortName')
      ->where(['=', 'creatorId', Yii::$app->user->id])
      ->indexBy('shopId')
      ->column();

    $model->setScenario(Event::SCENARIO_STEP1);

    if ($model->load(Yii::$app->request->post()) && $model->save()) {
      if ($setFlash) {
        Yii::$app->session->setFlash('success', 'Акция успешно добавлена.
                Вы можете продолжить заполнение информации о акции сейчас, либо позже.');
      }
      return $this->redirect(["/events/$model->id/update/info"]);
    }
    return $this->render('create/step-1', [
      'model' => $model,
      'eventOwner' => $eventOwner,
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
    $model->setScenario(Event::SCENARIO_STEP2);

    if ($model->load(Yii::$app->request->post()) && $model->save()) {
      return $this->redirect(["/events/$model->id/update/photo"]);
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
    $model->setScenario(Event::SCENARIO_STEP3);

    if ($model->load(Yii::$app->request->post()) && $model->save()) {
      $model->uploadedEventPhoto = UploadedFile::getInstances($model, 'uploadedEventPhoto');

      if ($model->uploadEventPhoto()) {
        return $this->refresh();
      }
    }
    return $this->render('create/step-3', [
      'model' => $model,
    ]);
  }

  /**
   * Updates an existing Event model.
   * If update is successful, the browser will be redirected to the 'view' page.
   * @param integer $id
   * @return mixed
   * @throws NotFoundHttpException if the model cannot be found
   */
  public function actionUpdate($id)
  {
    $model = $this->findModel($id);

    if (Yii::$app->request->isPost) {
      $model->uploadedEventPhoto = UploadedFile::getInstances($model, 'uploadedEventPhoto');

      if ($model->uploadEventPhoto()) {
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
   * Disactivate an existing Event model.
   * If disactivation is successful, the browser will be redirected to the 'index' page.
   * @param integer $id
   * @return mixed
   * @throws NotFoundHttpException if the model cannot be found
   */
  public function actionDelete($id)
  {
    $model = $this->findModel($id);
//    $model->setScenario(Event::SCENARIO_DEFAULT);
    $model->active = Event::STATUS_DISABLE;
    if ($model->save()) {
        return $this->redirect(['user/business']);
    }

    return $this->redirect(['user/business']);
  }

  /**
   * Finds the Event model based on its primary key value.
   * If the model is not found, a 404 HTTP exception will be thrown.
   * @param integer $id
   * @return Event the loaded model
   * @throws NotFoundHttpException if the model cannot be found
   */
  protected function findModel($id)
  {
    if (($model = Event::findOne($id)) !== null) {
      return $model;
    }

    throw new NotFoundHttpException('The requested page does not exist.');
  }
}
