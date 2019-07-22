<?php

/* @var $this yii\web\View */

use app\assets\AppAsset;
use app\assets\ProfileMapsAsset;
use yii\authclient\widgets\AuthChoice;
use yii\bootstrap4\Modal;
use yii\helpers\Html;
use yii\helpers\Url;


$this->registerLinkTag(['rel' => 'icon', 'type' => 'image/png', 'href' => Url::to(['img/main/favicon.png'])]);
$this->registerCssFile('/css/contactForm.css');
$this->registerJsFile('/js/contactForm.js', ['depends' => 'app\assets\AppAsset']);
$this->registerJsFile('/js/slider.js');
AppAsset::register($this);
ProfileMapsAsset::register($this);
$this->title = "I'm Local";
?>

<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body class="elipse">
<?php $this->beginBody() ?>

<div class="container-fluid bottom-img">
    <div class="container">
        <nav class="navbar navbar-expand-lg navbar-light">
            <a class="navbar-brand" href="<?php Yii::$app->homeUrl ?>">
                <img src="img/main/logo.png" width="30" height="30" class="d-inline-block logo-img" alt="i’m local">
                <span class="logo-text">i’m local</span>
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item ml-auto active">
                        <a class="nav-link" href="<?php Yii::$app->homeUrl ?>">Главная</a>
                    </li>
                    <li class="nav-item ml-auto">
                        <a class="nav-link" href="/user/business">Бизнесу</a>
                    </li>
                    <?php if (!Yii::$app->user->isGuest) { ?>
                        <li class="nav-item ml-auto">
                            <a class="nav-link" href="/favorites">Избранное</a>
                        </li>
                    <?php } ?>
                    <li class="nav-item ml-auto">
                    <?php
                    Modal::begin([
                        'bodyOptions' => ['id' => 'contact-form'],
                        'toggleButton' => [
                            'label' => 'Помощь',
                            'tag' => 'a',
                            'class' => 'contact-form nav-link',
                        ],
                        'closeButton' => [
                            'class' => 'btn btn-coral',
                            'label' => 'Закрыть'
                        ]
                    ]);
                    ?>
                    <div class="modal-body"></div>
                    <?php Modal::end(); ?>
                    </li>
                    <?php if (Yii::$app->user->isGuest) { ?>
                    <li class="nav-item ml-auto">
                    <?php
                    Modal::begin([
                        'bodyOptions' => ['id' => 'modal-enter'],
                        'toggleButton' => [
                            'label' => 'Вход<span class="login-ellipse"></span>',
                            'tag' => 'a',
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
                    <p class="enter-policy">Продолжая, Вы соглашаетесь с нашими Условиями использования и подтверждаете, что прочли
                        <a href="/policy" target="_blank">Политику конфиденциальности</a> .</p>
                    <?php Modal::end(); ?>
                    </li>
                    <?php } else { ?>
                        <a href="/login">Профиль</a>
                        <a href="/site/logout">Выход</a>
                    <?php } ?>
                </ul>
            </div>
        </nav>
    </div>

    <div class="container">
        <div class="mt-5 d-none d-md-block"></div>
        <div class="row">
            <div class="col-md-6 offset-md-3 col-12">
                <h1 class="h1">I’m local – ваш гид по местам в округе</h1>
            </div>
            <div class="col-md-6 col-12 mt-3">
                <div class="row">
                    <div class="col-2 list-num">1.</div>
                    <div class="col-10 list-text">Открывайте новые места и узнавайте о том, что происходит поблизости.</div>
                </div>
                <div class="row">
                    <div class="col-2 list-num">2.</div>
                    <div class="col-10 list-text">Удобный поиск и возможность сохранять.</div>
                </div>
                <div class="row">
                    <div class="col-2 list-num">3.</div>
                    <div class="col-10 list-text">Новое качество жизни: взгляните по-новому на свой район и не тратьте время на долгие поездки.</div>
                </div>

                <form action="/shops" method="get" class="text-center main-form">
                    <input type="hidden" name="coords_address" id="coords_address" value="">
                    <div class="form-group">
                        <?php
                        Modal::begin([
                            'size' => 'modal-lg',
                            'toggleButton' => [
                                'label' => '<input type="text" class="form-control input input-place" id="input_address" data-toggle="modal" data-target="#exampleModal" value="Выберите местоположение">
                        <span class="input-label"><img src="img/main/building.png" alt="Выберите место"></span>',
                                'tag' => 'a',
                                'class' => '',
                            ],
                            'closeButton' => [
                                'class' => 'btn btn-coral',
                                'label' => 'Выбрать'
                            ]
                        ]);

                        ?>
                        <div class="modal-body">
                            <div id="profile_map"></div>
                        </div>
                        <?php Modal::end(); ?>
                    </div>
                    <div class="form-group">
                        <div class="slidecontainer input form-control bg-white">
                            <input type="range" min="1" max="11" value="5" class="slider" id="round_range">
                        </div>
                        <span class="range-text">На расстоянии <span id="range_text" class="range-value">1 км</span></span>
                        <span class="input-label"><img src="img/main/aim.png" alt="Выберите место"></span>
                    </div>
                    <button class="btn index-start-btn">Начать</button>
                </form>

            </div>
            <div class="col-md-6 col-12 d-none d-md-block" >
                <img src="img/main/index-bg-img.png" alt="people" height="585px">
            </div>
        </div>

    </div>
</div>
<footer class="footer text-gray pt-2">
    <div class="container">
        <div class="row">
            <div class="col-md-6 col-12">
                <a class="footer-link" href="/about">О проекте</a>&nbsp;
                <a class="footer-link" href="/policy" target="_blank">Политику конфиденциальности</a>&nbsp;
                <a class="footer-link" href="#">Помощь</a>
            </div>
            <div class="col-md-6 col-12 text-right">© 2019, i’m local</div>
        </div>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
