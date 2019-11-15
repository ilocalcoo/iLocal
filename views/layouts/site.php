<?php

/* @var $this \yii\web\View */
/* @var $content string */

use app\assets\MainAsset;
use app\assets\ProfileMapsAsset;
use yii\bootstrap4\Modal;
use yii\helpers\Url;
use yii\helpers\Html;

$this->registerLinkTag(['rel' => 'icon', 'type' => 'image/png', 'href' => Url::to(['img/main/favicon.png'])]);
$this->title = "I'm Local";

MainAsset::register($this);

$this->beginPage() ?>
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
				<img <?php if(strstr(Yii::$app->controller->route, 'about')) { ?>
					src="img/about/white-logo.png"
					<?php } else { ?>
					src="img/main/logo.png"
					<?php } ?>
					width="30" height="30" class="d-inline-block logo-img" alt="i’m local">
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

<div class="wrap">
	<div class="container">
    <?= $content ?>
	</div>
</div>

<footer class="footer text-gray pt-2 mt-3">
	<div class="container">
		<div class="row">
			<div class="col-md-6 col-12">
				<a class="footer-link" href="/site/about">О проекте</a>&nbsp;
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

<!-- Yandex.Metrika counter -->
<script type="text/javascript" >
    (function(m,e,t,r,i,k,a){m[i]=m[i]||function(){(m[i].a=m[i].a||[]).push(arguments)};
        m[i].l=1*new Date();k=e.createElement(t),a=e.getElementsByTagName(t)[0],k.async=1,k.src=r,a.parentNode.insertBefore(k,a)})
    (window, document, "script", "https://mc.yandex.ru/metrika/tag.js", "ym");

    ym(56240335, "init", {
        clickmap:true,
        trackLinks:true,
        accurateTrackBounce:true,
        webvisor:true
    });
</script>
<noscript><div><img src="https://mc.yandex.ru/watch/56240335" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
<!-- /Yandex.Metrika counter -->

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
