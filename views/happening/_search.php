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

    <?= $form->field($model, 'isEventTop')->checkbox() ?>

    <?= $form->field($model, 'shortDesc')->widget(
        AutoComplete::className(), [
        'clientOptions' => [
            'source' => $shortDescData,
            'minLength' => '2',
        ],
        'options' => [
            'class' => 'form-control'
        ]
    ])->label('Search'); ?>

    <?php echo $form->field($model, 'begin')->widget(
        \yii\jui\DatePicker::class, [
            'model' => $model,
        ]) ?>

    <?php echo $form->field($model, 'end')->widget(
        \yii\jui\DatePicker::class, [
        'model' => $model,
    ]) ?>

	<div class="form-group">
      <?= Html::submitButton('Search', ['class' => 'btn btn-coral']) ?>
      <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-coral']) ?>
	</div>

    <?php ActiveForm::end(); ?>

</div>
