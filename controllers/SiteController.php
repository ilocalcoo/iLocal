<?php

namespace app\controllers;

use app\components\AuthHandler;
use app\models\Event;
use app\models\Happening;
use app\models\Shop;
use app\models\User;
use app\models\UserAddress;
use app\models\UserEvent;
use app\models\UserShop;
use Yii;
use yii\filters\AccessControl;
use yii\helpers\Html;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;

class SiteController extends Controller
{
  /**
   * {@inheritdoc}
   */
  public function behaviors()
  {
    return [
      'access' => [
        'class' => AccessControl::className(),
        'only' => ['logout'],
        'rules' => [
          [
            'actions' => ['logout'],
            'allow' => true,
            'roles' => ['@'],
          ],
        ],
      ],
      'verbs' => [
        'class' => VerbFilter::className(),
        'actions' => [
//                    'logout' => ['post'],
        ],
      ],
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function actions()
  {
    return [
      'error' => [
        'class' => 'yii\web\ErrorAction',
      ],
      'captcha' => [
        'class' => 'yii\captcha\CaptchaAction',
        'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
      ],
      // Добавляем действие для аутентификации через соцсети.
      'auth' => [
//                'class' => 'app\components\ExtendedAuthAction',
        'class' => 'yii\authclient\AuthAction',
        'successCallback' => [$this, 'onAuthSuccess'],
      ],
    ];
  }

  /**
   * Метод вызывается когда пользователь был успешно аутентифицирован через внешний сервис.
   * @param $client - Через экземпляр $client мы можем извлечь полученную информацию.
   */
  public function onAuthSuccess($client)
  {
    (new AuthHandler($client))->handle();
  }

  /**
   * Displays homepage.
   *
   * @return string
   */
  public function actionIndex()
  {
    $this->layout = 'site';
    $query = Shop::find()->where(['shopActive' => 1])->cache(10);
    $shops = $query->limit(10)->all();
    $query = Event::find()->where(['active' => 1])->cache(10);
    $events = $query->limit(10)->all();
      $query = Happening::find()->where(['active' => 1])->cache(10);
      $happenings = $query->limit(10)->all();
    if (!Yii::$app->user->isGuest) {
      $user = User::current();
      if (!is_null($user->userAddress)) {
        $latitude = $user->userAddress->latitude;
        $longitude = $user->userAddress->longitude;
        $userCoords = $latitude . ', ' . $longitude;
      } else {$userCoords = null;}
    } else {
      $userCoords = null;
    }

    return $this->render('index', [
      'events' => $events,
      'shops' => $shops,
      'happenings' => $happenings,
      'userCoords' => $userCoords,
    ]);
  }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        $model = null;

        if (!Yii::$app->user->isGuest) {
            /** @var User $model */
            $model = Yii::$app->user->getIdentity();

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

                if ($model->userAddress) {
                    $modelAddress = $model->userAddress;
                } else {
                    $modelAddress = new UserAddress();
                }


                $modelAddress->city = $addressArray[0];
                $modelAddress->street = $addressArray[1];
                $modelAddress->houseNumber = $addressArray[2];
                if (Yii::$app->request->post('coords')) {
                    $coords = explode(',', Yii::$app->request->post('coords'));
                    $modelAddress->latitude = $coords[0];
                    $modelAddress->longitude = $coords[1];
                }


                if ($modelAddress->save()) {
                    $model->userAddressId = $modelAddress->id;
                    $model->save();
                    Yii::$app->getSession()->setFlash('success', 'Адрес сохранен');
                    return $this->refresh();
                }

            }


            if (Yii::$app->request->post('user')) {
                if ($model->load(Yii::$app->request->post()) && $model->save()) {
                    Yii::$app->getSession()->setFlash('success', 'Изменения сохранены');
                    return $this->refresh();
                }
            }
            return $this->render('login', [
                'model' => $model,
            ]);
        }

        return $this->redirect('/');
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();
    return $this->goHome();
  }


  public function actionContact()
  {
    $model = new ContactForm();
    return $this->render('contact', [
      'model' => $model,
    ]);
  }


  /**
   * Displays contact page.
   *
   * @return Response|string
   */
  public function actionContactsend()
  {
    $model = new ContactForm();
    if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
      $success = true;
      return json_encode($success);
    }
    return $this->render('contact', [
      'model' => $model,
    ]);
  }

  /**
   * Displays about page.
   *
   * @return string
   */
  public function actionAbout()
  {
    $this->layout = 'site';
    return $this->render('about');
  }

  /**
   * Displays policy page.
   *
   * @return string
   */
  public function actionPolicy()
  {
      $this->layout = 'site';
      return $this->render('policy');
  }

  /**
   * Displays favorites page.
   *
   * @return string
   */
  public function actionFavorites()
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
      if ($userShop) {
          $userShop->delete();
      }
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
        if ($userEvent) {
            $userEvent->delete();
        }
    }

    $userShops = User::findOne(Yii::$app->user->id)->shopsFavorites;
    $userEvents = User::findOne(Yii::$app->user->id)->eventsFavorites;

    return $this->render('favorites', [
      'userShops' => $userShops,
      'userEvents' => $userEvents
    ]);
  }

}
