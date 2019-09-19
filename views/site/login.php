<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\User */

/* @var $title string */

use app\assets\AppAsset;
use app\widgets\Alert;
use yii\bootstrap4\Modal;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\bootstrap\ActiveForm;

\app\assets\ProfileMapsAsset::register($this);
AppAsset::register($this);
//$this->registerCssFile('/css/login.css');

$this->title = 'Профиль';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="site-login">
    <h1 class="profile-title"><?= Html::encode($this->title) ?></h1>
    <div class="edit_per"><h2>Логин: <?= Yii::$app->user->identity->username ?></h2></div>
    <div class="row">
        <div class="col-md-6 col-12">
            <?php if (!Yii::$app->user->isGuest): ?>
            <?= Alert::widget() ?>
            <div class="edit_per">
                <div class="formed">
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
                            <?= Html::submitButton('Сохранить данные', ['class' => 'btn btn-outline-coral']) ?>
                        </div>
                    </div>
                    <?php ActiveForm::end() ?>
                </div>
            </div>

        </div>
        <div class="col-md-6 col-12 formed edit_per">
            <label>Адрес:</label>
            <?= Html::beginForm(); ?>
            <?= Html::hiddenInput('address', '', ['id' => 'input_address']); ?>
            <?= Html::hiddenInput('coords', '', ['id' => 'coords_address']); ?>
            <div class="form-group main-group">
                <?php
                $comma = [];
                foreach (ArrayHelper::toArray($model->userAddress) as $key => $item) {
                    if ($key == 'id' || $item == '') {
                        continue;
                    }
                    if ($key == 'latitude') {
//                    $comma = '. Координаты: <span id="user_coordinates">';
                        continue;
                    }

                    if ($key == 'longitude') {
                        //echo '</span>';
                        continue;
                    }
                    //echo $comma . $item;
                    $comma[] = $item;
                }
                ?>
                <?php
                Modal::begin([
                    'size' => 'modal-lg',
                    'toggleButton' => [
                        'label' => '<div class="form-control" data-toggle="modal" data-target="#exampleModal">
                                    <span class="place-text" id="view_address">'.implode(', ',$comma).'</span>
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

            <br><br>
            <div class="form-group text-center">
                <div>
                    <!--            <div class="col-lg-offset-1 col-lg-11">-->
                    <?= Html::submitButton('Сохранить адрес', ['class' => 'btn btn-outline-coral']) ?>
                </div>
            </div>
            <?= Html::endForm(); ?>
        </div>
    </div>

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
