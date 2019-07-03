<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\jui\AutoComplete;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $model app\models\search\ShopSearch */
/* @var $form yii\widgets\ActiveForm */
/* @var $shopShortName app\models\Shop */
?>

<div class="shop-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <?= $form->field($model, 'shopShortName')
		->widget(
        AutoComplete::className(), [
        'clientOptions' => [
            'source' => $shopShortName,
            'minLength' => '2',
        ],
        'options'=>[
            'class'=>'form-control',
        	'value' => Yii::$app->request->get('shopShortName'),
		]
    ])->label('Поиск по названию места'); ?>

    <?php Pjax::begin(); ?>
    <div class="form-group">
        <?= Html::submitButton('Искать', ['class' => 'btn search-button']) ?>
        <?= Html::resetButton('Сбросить', [
        	'class' => 'btn',
			'id' => 'reset_button',
			]) ?>
    </div>
    <?php Pjax::end(); ?>
    <?php ActiveForm::end(); ?>

</div>
