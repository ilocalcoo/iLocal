<?php

/* @var $this yii\web\View */

use app\assets\MainAsset;
use app\assets\ProfileMapsAsset;
use app\models\Shop;
use yii\authclient\widgets\AuthChoice;
use yii\bootstrap4\Modal;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;

/* @var $this yii\web\View */
/* @var $shops app\models\Shop[] */
/* @var $events app\models\Event[] */
/* @var $userCoords string */

$this->registerLinkTag(['rel' => 'icon', 'type' => 'image/png', 'href' => Url::to(['img/main/favicon.png'])]);
MainAsset::register($this);
ProfileMapsAsset::register($this);
$this->title = "I'm Local";
?>

<?php $this->beginPage() ?>
	<!DOCTYPE html>
	<html lang="<?= Yii::$app->language ?>">
	<head>
		<base href="<?= Url::base(true) ?>">
		<meta charset="<?= Yii::$app->charset ?>">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
    <?php $this->registerCsrfMetaTags() ?>
		<title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
	</head>
	<body class="elipse">
  <?php $this->beginBody() ?>

	<div class="container">
		<nav class="my-header">
			<div class="left-header">
				<a class="d-md-none d-sm-block menu-toggler" href="">
					<div class="pol"></div>
					<div class="pol"></div>
					<div class="pol"></div>
				</a>
				<a href="/">
					<img src="img/main/logo.png" width="30" height="30" class="d-inline-block logo-img" alt="i’m local">
					<span class="logo-text">i’m local</span>
				</a>
			</div>
			<div class="content-desc" id="navbarNav">
				<ul class="menu-list">
					<img src="img/main/close.svg" class="nav-link" id="close" alt="close" width="32px" height="32px">
					<li class="nav-item d-none d-md-block">
						<a class="nav-link" href="/">Главная</a>
					</li>
          <?php if (!Yii::$app->user->isGuest) { ?>
						<li class="nav-item business">
							<a class="nav-link" href="/user/business">
								<img src="img/main/business.svg" alt="business">
								Бизнесу</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" href="/favorites">
								<img src="img/main/favor.svg" alt="favorite">
								Избранное</a>
						</li>
          <?php } ?>
					<li class="nav-item">
            <?php
            Modal::begin([
              'toggleButton' => [
                'label' => '<img src="img/main/help.svg" alt="help">Помощь',
                'tag' => 'a',
                'type' => '',
                'class' => 'contact-form nav-link',
              ],
            ]);
            ?>
						<div class="modal-body contact-modal-body"></div>
            <?php Modal::end(); ?>
					</li>
          <?php if (Yii::$app->user->isGuest) { ?>
						<li class="nav-item login">
              <?php Modal::begin([
                'bodyOptions' => ['id' => 'modal-enter'],
                'toggleButton' => [
                  'label' => '<img src="img/main/login.svg" alt="login">Вход<span class="login-ellipse"></span>',
                  'tag' => 'a',
                  'type' => '',
                  'class' => 'modal-enter nav-link',
                ],
              ]);
              ?>
							<div class="modal-enter-body">
								<h2>ВХОД</h2>
								<p>Через социальные сети</p>
							</div>
							<div class="enter-icons">
                <?= yii\authclient\widgets\AuthChoice::widget([
                  'baseAuthUrl' => ['site/auth'],
                  'popupMode' => true,
                ]) ?>
							</div>
							<p class="enter-policy">Продолжая, Вы соглашаетесь с нашими Условиями использования и подтверждаете, что
								прочли
								<a href="/policy" target="_blank">Политику конфиденциальности</a>.</p>
              <?php Modal::end(); ?>
						</li>
          <?php } else { ?>
						<li class="nav-item profile">
							<a class="nav-link" href="">
								<img src="img/main/login.svg" alt="user">
                <?= Yii::$app->user->getIdentity()->username ?>
							</a>
						</li>
						<li class="nav-item logout">
							<a class="nav-link" href="/logout">
								<img src="img/main/logout.svg" alt="login">
								Выход</a>
						</li>
          <?php } ?>
				</ul>
			</div>
		</nav>
	</div>

		<div class="container">
			<div class="mt-5 d-none d-md-block"></div>
			<div class="row">
				<div class="col-md-6 col-12 mt-3">
					<h1 class="h1">I’m local – ваш гид по местам в округе</h1>
					<!--                <div class="d-none d-md-block">-->
					<!--                    <div class="row">-->
					<!--                        <div class="col-2 list-num">1.</div>-->
					<!--                        <div class="col-10 list-text">Открывайте новые места и узнавайте о том, что происходит поблизости.</div>-->
					<!--                    </div>-->
					<!--                    <div class="row">-->
					<!--                        <div class="col-2 list-num">2.</div>-->
					<!--                        <div class="col-10 list-text">Удобный поиск и возможность сохранять.</div>-->
					<!--                    </div>-->
					<!--                    <div class="row">-->
					<!--                        <div class="col-2 list-num">3.</div>-->
					<!--                        <div class="col-10 list-text">Новое качество жизни: взгляните по-новому на свой район и не тратьте время на долгие поездки.</div>-->
					<!--                    </div>-->
					<!--                </div>-->

					<form action="/shops" method="get" class="text-center main-form">
						<input type="hidden" name="coords_address" id="coords_address" value="">
						<input type="hidden" id="input_address" value="">
            <?php if (!is_null($userCoords)) { ?>
							<span id="user_coordinates" style="display: none"><?= $userCoords ?></span>
            <?php } ?>
						<div class="form-group main-group">
              <?php
              Modal::begin([
                'size' => 'modal-lg',
                'toggleButton' => [
                  'label' => '<div class="form-control input input-place" data-toggle="modal" data-target="#exampleModal">
                                    <span class="place-text" id="view_address">Выберите местоположение</span>
                                    <span class="input-label"><img src="img/main/building.png" alt="Выберите место"></span>
                                <span class="input-label-right"><i class="fas fa-chevron-right"></i></span>
                                </div>',
                  'tag' => 'a',
                  'class' => '',
                  'type' => '',
                ],
                'closeButton' => [
                  'class' => 'btn btn-coral',
                  'label' => 'Выбрать / Закрыть'
                ]
              ]);
              ?>
							<div class="modal-body">
								<div id="profile_map"></div>
							</div>
              <?php Modal::end(); ?>
						</div>
						<div class="form-group main-group">
							<div class="slidecontainer input form-control bg-white">
								<input type="range" min="1" max="11" value="5" class="slider" id="round_range" name="round_range">
							</div>
							<span class="range-text">На расстоянии <span id="range_text" class="range-value">1 км</span></span>
							<span class="input-label"><img src="img/main/aim.png" alt="Выберите место"></span>
						</div>
						<button class="btn btn-coral w-100">Начать</button>
					</form>

				</div>
				<div class="col-md-6 col-12 d-none d-md-block">
					<img src="img/main/index-bg-img.png" alt="people" height="485px">
				</div>
			</div>
		</div>
	</div>


<section id="actions">
    <div class="container mt-5">
        <div class="w-100 mb-3"><span class="h3">Акции</span><span style="float: right"><a href="/events"><button  class="btn btn-outline-coral">Все акции</button></a></span></div>
        <div class="row">
            <div class="col-12 scrolls" id="scrolls">
                <?php foreach ($events as $event) { ?>
						<div class="slide col-md-3 col-8 align-top">
							<a href="/events/<?= $event->id ?>">
								<div class="slide-img">
									<img width="277px"
											 src="<?= '/img/eventPhoto/' . ($event->eventPhotos ? $event->eventPhotos[0]->eventPhoto : 'nofoto') ?>"
											 alt="<?= $event->title ?>">
									<div class="overlay">
										<a class="overlay-link" href="/events/<?= $event->id ?>"><?= $event->title ?></a>
									</div>
									<span class="badge badge-coral">-15%</span>
								</div>
								<div class="slide-header"><?= $event->eventOwner->shopShortName ?></div>
								<div class="slide-text"><?= mb_substr($event->shortDesc, 0, 52) . '...' ?></div>
							</a>
						</div>

          <?php } ?>
				</div>
			</div>
		</div>
	</section>
  <?php if (!empty($happenings)) { ?>
		<section id="happening">
			<div class="container mt-5">
				<div class="w-100 mb-3"><span class="h3">События рядом с вами</span></div>
				<div class="row">
          <?php foreach ($happenings as $happening) { ?>
						<div class="event-item col-md-4 col-12">
							<div class="slide-img happening-img">
								<img
									src="/img/happeningPhoto/<?php $happeningPhoto = $happening->getPhotos()->asArray()->one()['happeningPhoto'];
                  if (is_null($happeningPhoto)) {
                    $happeningPhoto = '/img/nophoto.jpg';
                  }
                  echo $happeningPhoto ?>" alt="<?= $happening->title ?>">
								<div class="overlay">
									<a class="overlay-link event-link" href="#">Мастер-класс для детей “Построй свой замок”
										<div class="event-date">13:00 18.07.19</div>
									</a>
								</div>
								<span class="badge badge-coral">Free</span>
							</div>
						</div>
          <?php } ?>
				</div>
				<a href="/iLocal/events.html">
					<button class="btn btn-outline-coral w-100">Все события</button>
				</a>
			</div>
		</section>
  <?php } ?>
	<section id="shops">
		<div class="container mt-5">
			<div class="w-100 mb-3"><span class="h3">Места</span><span style="float: right"><a href="/shops"><button
							class="btn btn-outline-coral">Все места</button></a></span></div>
			<div class="row">
				<div class="col-12 scrolls" id="scrolls">
          <?php foreach ($shops as $shop) { ?>
						<div class="slide col-md-3 col-8">
							<a href="/shops/<?= $shop->shopId ?>">
								<div class="slide-img">
									<img style="height: 200px" src="/img/shopPhoto/<?php
                  $shopPhoto = $shop->getShopPhotos()->asArray()->one()['shopPhoto'];
                  if (is_null($shopPhoto)) {
                    $shopPhoto = '/img/nophoto.jpg';
                  }
                  echo $shopPhoto ?>" alt="<?= $shop->shopShortName ?>" data-pjax="0">
									<div class="overlay">
										<a class="overlay-link event-link" href="<?= 'shops/' . $shop->shopId ?>"
											 data-pjax="0"><?= $shop->shopShortName ?>
											<div class="event-date">1 км</div>
										</a>
									</div>
									<span class="badge badge-coral"><?= number_format($shop->shopRating, 1, '.', ','); ?></span>
								</div>
							</a>
						</div>
          <?php } ?>
				</div>

			</div>
		</div>
	</section>

	<footer class="footer text-gray pt-2 mt-3">
		<div class="container">
			<div class="row">
				<div class="col-md-6 col-12">
					<!--				Показать ссылку "О проекте", когда сделаем страницу -->
					<!--				<a class="footer-link d-md-none d-sm-block" href="/about">О проекте</a>&nbsp;-->
					<a class="small-text" href="/policy" target="_blank">Политика конфиденциальности</a>&nbsp;
          <?php Modal::begin([
            'toggleButton' => [
              'label' => 'Помощь',
              'tag' => 'a',
              'type' => '',
              'class' => 'contact-form footer-link d-md-none d-sm-block',
            ],
          ]);
          ?>
					<div class="modal-body contact-modal-body"></div>
          <?php Modal::end(); ?>
				</div>
				<div class="col-md-6 col-12 small-text">© 2019, i’m local</div>
			</div>
		</div>
	</footer>
	<div class="backdrop"></div>

  <?php $this->endBody() ?>
	</body>
	</html>
<?php $this->endPage() ?>