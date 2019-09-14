<?php

/* @var $this \yii\web\View */

/* @var $content string */

use yii\bootstrap4\Modal;
use yii\helpers\Html;
use app\assets\AppAsset;
use yii\helpers\Url;


$this->registerLinkTag(['rel' => 'icon', 'type' => 'image/png', 'href' => Url::to(['img/main/favicon.png'])]);
$this->registerCssFile('/css/contactForm.css');
$this->registerJsFile('/js/contactForm.js', ['depends' => 'app\assets\AppAsset']);
$this->registerJsFile('/js/slider.js');

$currentUrl = substr(Yii::$app->request->pathInfo, 0, 4);

function active($value)
{
  if (substr(Yii::$app->request->url, -8) == $value) {
    return true;
  }
  return false;
}

AppAsset::register($this);
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
<body style="background: #FCF7F4">
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
					<li class="nav-item">
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
              'label' => '<img src="img/main/help.svg" alt="help"> Помощь',
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
					<li class="nav-item">
            <?php Modal::begin([
              'bodyOptions' => ['id' => 'modal-enter'],
              'toggleButton' => [
                'label' => '<img src="img/main/login.svg" alt="login"> Вход<span class="login-ellipse"></span>',
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
							<a href="/policy" target="_blank">Политику конфиденциальности</a> .</p>
            <?php Modal::end(); ?>
					</li>
        <?php } else { ?>
					<li class="nav-item">
						<a class="nav-link" href="/login">Профиль</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="/logout">Выход</a>
					</li>
        <?php } ?>
			</ul>
		</div>
	</nav>
</div>
<div class="container">
	<div class="mt-3 d-none d-md-block"></div>
	<div class="row">
		<div class="col-md-4 col-12">
			<div class="row nav-bar-categories-main">
				<div class="col-4 nav-bar-categories-main-item <?php echo $currentUrl == 'shop' ? 'item-active' : ''; ?>">
					<a href="/shops" class="category-link">Места</a>
				</div>
				<div class="col-4 nav-bar-categories-main-item <?php echo $currentUrl == 'even' ? 'item-active' : ''; ?>">
					<a href="/events" class="category-link">Акции</a>
				</div>
				<div class="col-4 nav-bar-categories-main-item <?php echo $currentUrl == 'happening' ? 'item-active' : ''; ?>">
					<a href="/happenings" class="category-link">События</a></div>
			</div>

		</div>
		<div class="col-md-8 col-12 scrolls">
			<div class="nav-bar-categories" style="margin-bottom: 23px; margin-top: 23px;">
        <?php if ($currentUrl == 'even') { ?>
					<a
						href="/events?eventTypeId=1" <?php if (active('TypeId=1')) echo 'class="nav-bar-categories-active"' ?>>Еда</a>
					<a
						href="/events?eventTypeId=2" <?php if (active('TypeId=2')) echo 'class="nav-bar-categories-active"' ?>>Дети</a>
					<a href="/events?eventTypeId=3" <?php if (active('TypeId=3')) echo 'class="nav-bar-categories-active"' ?>>Спорт</a>
					<a href="/events?eventTypeId=4" <?php if (active('TypeId=4')) echo 'class="nav-bar-categories-active"' ?>>Красота</a>
					<a href="/events?eventTypeId=5" <?php if (active('TypeId=5')) echo 'class="nav-bar-categories-active"' ?>>Покупки</a>
					<a href="/events">Все</a>
        <?php } elseif ($currentUrl == 'shop') { ?>
					<a
						href="/shops?shopTypeId=1" <?php if (active('TypeId=1')) echo 'class="nav-bar-categories-active"' ?>>Еда</a>
					<a
						href="/shops?shopTypeId=2" <?php if (active('TypeId=2')) echo 'class="nav-bar-categories-active"' ?>>Дети</a>
					<a
						href="/shops?shopTypeId=3" <?php if (active('TypeId=3')) echo 'class="nav-bar-categories-active"' ?>>Спорт</a>
					<a href="/shops?shopTypeId=4" <?php if (active('TypeId=4')) echo 'class="nav-bar-categories-active"' ?>>Красота</a>
					<a href="/shops?shopTypeId=5" <?php if (active('TypeId=5')) echo 'class="nav-bar-categories-active"' ?>>Покупки</a>
					<a href="/shops">Все</a>
        <?php } ?>
			</div>
		</div>
	</div>

</div>


<div class="wrap">
	<div class="container">
    <?= $content ?>
	</div>
</div>

<footer class="footer text-gray pt-2 mt-3">
	<div class="container">
		<div class="row">
			<div class="col-md-6 col-12">
				<a class="footer-link" href="/about">О проекте</a>&nbsp;
				<a class="footer-link" href="/policy" target="_blank">Политика конфиденциальности</a>&nbsp;
        <?php Modal::begin([
          'toggleButton' => [
            'label' => 'Помощь',
            'tag' => 'a',
            'class' => 'contact-form footer-link',
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

<?php $this->endBody() ?>


</body>
</html>
<?php $this->endPage() ?>
