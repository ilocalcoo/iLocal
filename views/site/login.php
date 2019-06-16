<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\User */

/* @var $title string */

use app\widgets\Alert;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\bootstrap\ActiveForm;

\app\assets\ProfileMapsAsset::register($this);
$this->registerCssFile('/css/login.css');

$this->title = 'Профиль';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="site-login">
    <?php if (!Yii::$app->user->isGuest): ?>
        <?= Alert::widget() ?>

        <h1><?= Html::encode($this->title) ?></h1>
        <h2>Логин: <?= Yii::$app->user->identity->username ?></h2>


        <?php
    $form = ActiveForm::begin([
        'id' => 'user-form',
        'options' => ['class' => 'form-horizontal'],
    ]) ?>
        <?= $form->field($model, 'lastName') ?>
        <?= $form->field($model, 'firstName') ?>
        <?= $form->field($model, 'middleName') ?>
        <div class="form-group">
            <div class="col-lg-offset-1 col-lg-11">
                <?= Html::submitButton('Сохранить данные', ['class' => 'btn btn-primary']) ?>
            </div>
        </div>
        <?php ActiveForm::end() ?>
        <hr>


        <b>Адрес:</b>
        <?
        $comma = '';
        foreach (ArrayHelper::toArray($model->userAddress) as $key => $item) {
            if ($key == 'id' || $item == '') {
                continue;
            }
            if ($key == 'latitude') {
                $comma = '. Координаты: <span id="user_coordinates">';
            }
            echo $comma . $item;
            if ($key == 'longitude') {
                echo '</span>';
            }
            $comma = ', ';
        }
        ?>
        <br><br>

        <i>Укажите на карте свой адрес, на основании него будут выдаваться предложения в Вашем микрорайоне</i>
        <div id="profile_map"></div>

        <?= Html::beginForm(); ?>
        <?= Html::hiddenInput('address', '', ['id' => 'profile_address']); ?>
        <div class="form-group text-center">
            <div>
<!--            <div class="col-lg-offset-1 col-lg-11">-->
                <?= Html::submitButton('Сохранить адрес', ['class' => 'btn btn-primary']) ?>
            </div>
        </div>
        <?= Html::endForm(); ?>


        <br>
        <hr>
        <h2 class="enter-other">Привязать другой аккаунт</h2>
    <?php else: ?>
        <h2 class="enter">ВХОД</h2>
        <p class="enter-text">Через социальные сети</p>
    <?php endif; ?>
    <div class="enter-icons">
        <?= yii\authclient\widgets\AuthChoice::widget([
            'baseAuthUrl' => ['site/auth'],
            'popupMode' => true,
        ]) ?>
    </div>
    <?php if (Yii::$app->user->isGuest): ?>
        <p class="enter-policy">Продолжая, Вы соглашаетесь с нашими Условиями использования и подтверждаете, что прочли
            <a href="/policy" target="_blank">Политику конфиденциальности</a> .</p>
    <?php endif; ?>

    <?php if (!Yii::$app->user->isGuest): ?>
        <div class="enter-exit">
            <?= Html::beginForm(['/site/logout'], 'post') ?>
            <?= Html::submitButton(
                'Выйти (' . Yii::$app->user->identity->username . ')',
                ['class' => 'btn btn-danger logout']
            ) ?>
            <?= Html::endForm() ?>
        </div>
    <?php endif; ?>


</div>
