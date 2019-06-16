<?php

/* @var $this yii\web\View */

use app\assets\AppAsset;
use yii\bootstrap\Modal;
use yii\helpers\Html;

$this->registerCssFile('/css/contactForm.css');
$this->registerJsFile('/js/contactForm.js', ['depends' => 'app\assets\AppAsset']);
$this->registerCssFile('/css/main.css');
AppAsset::register($this);
$this->title = 'My Yii Application';
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
<body class="index-body">
<?php $this->beginBody() ?>

<div class="index-container">
    <div class="main-nav-bar">
        <a href="/">Главная</a>
        <?php if (!Yii::$app->user->isGuest) { ?>
            <a href="/user/business">Бизнесу</a>
            <a href="/favorites">Избранное</a>
        <?php } ?>
        <?php
        Modal::begin([
            'header' => false,
            'toggleButton' => [
                'label' => 'Помощь',
                'tag' => 'a',
                'class' => 'contact-form',
            ],
        ]);
        ?>
        <div class="modal-body"></div>
        <?php Modal::end(); ?>
<!--        <a href="">Поиск</a>-->
        <?php if (Yii::$app->user->isGuest) { ?>
            <a href="/login">Вход<span class="login-ellipse"></span></a>
        <?php } else { ?>
            <a href="/login">Профиль</a>
            <a href="/site/logout">Выход</a>
        <?php } ?>
    </div>
    <div class="index-main-wrap">
        <div class="index-info-main-wrap">
            <h1 class="index-info-header">Места, акции и события рядом с Вами</h1>
            <div class="index-info-wrap">
                <div class="index-info-num">
                    <div>1.</div>
                    <div>2.</div>
                    <div>3.</div>
                </div>
                <div class="index-info-text">
                    <div>Открывайте новые места и узнавайте о том, что происходит поблизости.</div>
                    <div>Удобный поиск и возможность сохранять.</div>
                    <div>Новое качество жизни: взгляните по-новому на свой район и не тратьте время на долгие поездки.
                    </div>
                    <div class="index-start-btn">
                    <a href="/shops" tabindex="1">Начать</a>
                    </div>
                </div>
            </div>
        </div>
        <img src="/img/main/index-bg-img.png" alt="">
    </div>
</div>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
