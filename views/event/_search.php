<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\jui\AutoComplete;

/* @var $this yii\web\View */
/* @var $model app\models\search\EventSearch */
/* @var $form yii\widgets\ActiveForm */
/* @var \app\models\Event $shortDescData */
?>

<div class="event-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

<!--    --><?//= $form->field($model, 'id') ?>
<!---->
<!--    --><?//= $form->field($model, 'active') ?>
<!---->
<!--    --><?//= $form->field($model, 'isEventTop') ?>
<!---->
<!--    --><?//= $form->field($model, 'eventOwnerId') ?>
<!---->
<!--    --><?//= $form->field($model, 'eventTypeId') ?>

		<?= $form->field($model, 'shortDesc')->widget(
        AutoComplete::className(), [
        'clientOptions' => [
            'source' => $shortDescData,
            'minLength' => '2',
        ],
        'options'=>[
            'class'=>'form-control'
        ]
    ])->label('Search'); ?>

    <?php // echo $form->field($model, 'title') ?>

    <?php // echo $form->field($model, 'shortDesc') ?>

    <?php // echo $form->field($model, 'fullDesc') ?>

    <?php // echo $form->field($model, 'begin') ?>

    <?php // echo $form->field($model, 'end') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
