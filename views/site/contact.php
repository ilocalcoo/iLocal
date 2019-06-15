<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 * @var yii\web\View $this
 * @var yii\widgets\ActiveForm $form
 */
?>
<div id="contact-form-content">
    <h1 class="contact-form_title">Обратная связь</h1>
    <div id="massage-error"></div>

        <?php $form = ActiveForm::begin(['options' => ['class' => 'contact-form']]); ?>

        <?= $form->field($model, 'subject', ['options' => ['class' => 'contact-form_subject']])->textInput(['autofocus' => true, 'placeholder' => 'Введите тему сообщения']) ?>

        <?= $form->field($model, 'email', ['options' => ['class' => 'contact-form_email']])->textInput(['placeholder' => 'Введите адрес Вашей электронной почты'])?>

        <?= $form->field($model, 'body', ['options' => ['class' => 'contact-form_body']])->textarea(['rows' => 13, 'placeholder' => 'Введите текст сообщения']) ?>

        <div class="form-group text-center">
            <div id="massage"></div>
            <?= Html::submitButton('Отправить', ['class' => 'contact-form_btn']) ?>
        </div>

        <?php ActiveForm::end(); ?>
</div>