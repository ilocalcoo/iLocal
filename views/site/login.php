<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\User */

/* @var $title string */

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\bootstrap\ActiveForm;

\app\assets\ProfileMapsAsset::register($this);

$this->title = 'Профиль';
$this->params['breadcrumbs'][] = $this->title;
?>


<?php
\yii\bootstrap\Modal::begin([
    'header' => '<h2>Hello world</h2>',
    'toggleButton' => ['label' => 'click me'],
]);

echo yii\authclient\widgets\AuthChoice::widget([
    'baseAuthUrl' => ['site/auth'],
    'popupMode' => false,
]);

\yii\bootstrap\Modal::end();
?>


<div class="site-login">
    <?php if (!Yii::$app->user->isGuest): ?>

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
        <?= Html::hiddenInput('address', '', ['id' => 'profile_address'] ); ?>
        <div class="form-group">
            <div class="col-lg-offset-1 col-lg-11">
                <?= Html::submitButton('Сохранить адрес', ['class' => 'btn btn-primary']) ?>
            </div>
        </div>
        <?= Html::endForm(); ?>
        <br>


        <br><hr>
        <h2>Привязать другой аккаунт</h2>
    <?php else: ?>
        <h2>Войдите или зарегистрируйтесь</h2>
    <?php endif; ?>
    <?= yii\authclient\widgets\AuthChoice::widget([
        'baseAuthUrl' => ['site/auth'],
        'popupMode' => true,
    ]) ?>

    <?php if (!Yii::$app->user->isGuest): ?>
        <?= Html::beginForm(['/site/logout'], 'post') ?>
        <?= Html::submitButton(
            'Выйти (' . Yii::$app->user->identity->username . ')',
            ['class' => 'btn btn-danger logout']
        ) ?>
        <?= Html::endForm() ?>
    <?php endif; ?>






    <!--    <p>Please fill out the following fields to login:</p>-->
    <!---->
    <!--    --><?php //$form = ActiveForm::begin([
    //        'id' => 'login-form',
    //        'layout' => 'horizontal',
    //        'fieldConfig' => [
    //            'template' => "{label}\n<div class=\"col-lg-3\">{input}</div>\n<div class=\"col-lg-8\">{error}</div>",
    //            'labelOptions' => ['class' => 'col-lg-1 control-label'],
    //        ],
    //    ]); ?>
    <!---->
    <!--        --><? //= $form->field($model, 'username')->textInput(['autofocus' => true]) ?>
    <!---->
    <!--        --><? //= $form->field($model, 'password')->passwordInput() ?>
    <!---->
    <!--        --><? //= $form->field($model, 'rememberMe')->checkbox([
    //            'template' => "<div class=\"col-lg-offset-1 col-lg-3\">{input} {label}</div>\n<div class=\"col-lg-8\">{error}</div>",
    //        ]) ?>
    <!---->
    <!--        <div class="form-group">-->
    <!--            <div class="col-lg-offset-1 col-lg-11">-->
    <!--                --><? //= Html::submitButton('Login', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
    <!--            </div>-->
    <!--        </div>-->
    <!---->
    <!--    --><?php //ActiveForm::end(); ?>
    <!---->
    <!--    <div class="col-lg-offset-1" style="color:#999;">-->
    <!--        You may login with <strong>admin/admin</strong> or <strong>demo/demo</strong>.<br>-->
    <!--        To modify the username/password, please check out the code <code>app\models\User::$users</code>.-->
    <!--    </div>-->
</div>
