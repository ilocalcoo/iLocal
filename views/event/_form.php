<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Event */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="event-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'active')->textInput() ?>

    <?= $form->field($model, 'isEventTop')->checkbox() ?>

    <?= $form->field($model, 'eventOwnerId')->textInput() ?>

    <?= $form->field($model, 'eventTypeId')->textInput() ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'eventPhotoId')->textInput() ?>

    <?= $form->field($model, 'shortDesc')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'fullDesc')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'begin')->textInput() ?>

    <?= $form->field($model, 'end')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
