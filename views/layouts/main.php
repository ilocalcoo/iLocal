<?php

/* @var $this \yii\web\View */

/* @var $content string */

use yii\helpers\Html;
use app\assets\AppAsset;

$currentUrl = substr(Yii::$app->request->pathInfo, 0, 4);

function active($value) {
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
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body class="main-body">
<?php $this->beginBody() ?>

<header class="main-header">
    <div class="header-container">
        <div class="main-nav-bar">
            <a href="/">Главная</a>
            <?php if (!Yii::$app->user->isGuest) { ?>
            <a href="/user/business">Бизнесу</a>
            <a href="/favorites">Избранное</a>
            <?php } ?>
            <a href="">Помощь</a>
            <a href="">Поиск</a>
            <?php if (Yii::$app->user->isGuest) { ?>
                <a href="/login">Вход<span class="login-ellipse"></span></a>
            <?php } else { ?>
                <a href="/login">Профиль</a>
                <a href="/site/logout">Выход</a>
            <?php } ?>
        </div>
        <div class="nav-bar-categories-wrap">
            <div class="nav-bar-categories-main">
                <a href="/shops" class="<?php if ($currentUrl == 'shop') {
                    echo 'nav-bar-categories-main-active';
                } else {
                    echo 'nav-bar-categories-main-inactive';
                }
                ?>">Места</a>
                <a href="/events" class="<?php if ($currentUrl == 'even') {
                    echo 'nav-bar-categories-main-active';
                } else {
                    echo 'nav-bar-categories-main-inactive';
                }
                ?>">Акции</a>
            </div>
            <div class="nav-bar-categories">
                <?php if ($currentUrl == 'even') { ?>
                    <a href="/events?eventTypeId=1" <?php if(active('TypeId=1')) echo 'class="nav-bar-categories-active"'?>>Еда</a>
                    <a href="/events?eventTypeId=2" <?php if(active('TypeId=2')) echo 'class="nav-bar-categories-active"'?>>Дети</a>
                    <a href="/events?eventTypeId=3" <?php if(active('TypeId=3')) echo 'class="nav-bar-categories-active"'?>>Спорт</a>
                    <a href="/events?eventTypeId=4" <?php if(active('TypeId=4')) echo 'class="nav-bar-categories-active"'?>>Красота</a>
                    <a href="/events?eventTypeId=5" <?php if(active('TypeId=5')) echo 'class="nav-bar-categories-active"'?>>Покупки</a>
                    <a href="/events">Все</a>
                <?php } else { ($currentUrl == 'shop') ?>
                    <a href="/shops?shopTypeId=1" <?php if(active('TypeId=1')) echo 'class="nav-bar-categories-active"'?>>Еда</a>
                    <a href="/shops?shopTypeId=2" <?php if(active('TypeId=2')) echo 'class="nav-bar-categories-active"'?>>Дети</a>
                    <a href="/shops?shopTypeId=3" <?php if(active('TypeId=3')) echo 'class="nav-bar-categories-active"'?>>Спорт</a>
                    <a href="/shops?shopTypeId=4" <?php if(active('TypeId=4')) echo 'class="nav-bar-categories-active"'?>>Красота</a>
                    <a href="/shops?shopTypeId=5" <?php if(active('TypeId=5')) echo 'class="nav-bar-categories-active"'?>>Покупки</a>
                    <a href="/shops">Все</a>
                <?php } ?>
            </div>
        </div>
    </div>
</header>

<div class="wrap">
    <div class="container">
        <?= $content ?>
    </div>
</div>

<footer class="main-footer footer">
<!--    <div class="bg-ellipse-footer"></div>-->
    <div class="container">
        <p class="pull-left"><a href="">Политика конфиденциальности</a></p>
        <p class="pull-right">&copy; I`m local, <?= date('Y') ?></p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
