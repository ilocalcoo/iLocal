<?php

/* @var $this \yii\web\View */

/* @var $content string */

use app\widgets\Alert;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;

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
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <?php
    NavBar::begin([
        'brandLabel' => Yii::$app->name,
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => [
            //['label' => 'Home', 'url' => ['/site/index']],
            ['label' => 'Business', 'url' => ['/user/business']],
            ['label' => 'Food', 'url' => ['/shops?shopTypeId=1']],
            ['label' => 'Child', 'url' => ['/shops?shopTypeId=2']],
            ['label' => 'Sport', 'url' => ['/shops?shopTypeId=3']],
            ['label' => 'Beauty', 'url' => ['/shops?shopTypeId=4']],
            ['label' => 'Buy', 'url' => ['/shops?shopTypeId=5']],
            ['label' => 'All places', 'url' => ['/shops']],
            //['label' => 'About', 'url' => ['/site/about']],
            //['label' => 'Contact', 'url' => ['/site/contact']],
            ['label' => 'Избранное', 'url' => ['/site/favorites']],
            Yii::$app->user->isGuest ? (
//            ['label' => 'Войти', 'url' => ['/site/login']]
                '<li>'
                . Html::beginForm(['/site/logout'], 'post')
                . Html::submitButton('Войти', [
                    'value' => Yii::$app->urlManager->createUrl('/site/login'),
                    'class' => 'btn btn-link logout',
                    'id' => 'BtnModalId',
                    'data-toggle' => 'modal',
                    'data-target' => '#your-modal',
                ])
                . Html::endForm()
                . '</li>'
            ) : (
            ['label' => 'Профиль', 'url' => ['/site/login']]
//            ['label' => Yii::$app->user->identity->username, 'url' => ['/site/login']]
//                '<li>'
//                . Html::beginForm(['/site/logout'], 'post')
//                . Html::submitButton(
//                    'Logout (' . Yii::$app->user->identity->username . ')',
//                    ['class' => 'btn btn-link logout']
//                )
//                . Html::endForm()
//                . '</li>'
            )
        ],
    ]);
    NavBar::end();
    ?>

    <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; My Company <?= date('Y') ?></p>

        <p class="pull-right"><?= Yii::powered() ?></p>
    </div>
</footer>

<?php $this->endBody() ?>


<?php
\yii\bootstrap\Modal::begin([
    'header' => '<h2>Hello world</h2>',
//    'toggleButton' => ['label' => 'click me'],
    'id' => 'modal',
]);

echo "<div id='modal-content'>";

echo yii\authclient\widgets\AuthChoice::widget([
    'baseAuthUrl' => ['site/auth'],
    'popupMode' => false,
]);

echo "</div>";

\yii\bootstrap\Modal::end();
?>
<script>
    $('#modal-btn').on('click', function () {
        $('#modal').modal('show')
            .find('#modal-content')
            .load($(this).attr('data-target'));
    });
</script>


</body>
</html>
<?php $this->endPage() ?>
