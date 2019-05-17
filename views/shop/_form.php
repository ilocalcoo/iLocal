<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Shop */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="shop-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'shopShortName')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'shopFullName')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'shopPhoto')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'shopType')->dropDownList([ 'food' => 'Food', 'child' => 'Child', 'sport' => 'Sport', 'beauty' => 'Beauty', 'buy' => 'Buy', ], ['prompt' => '']) ?>

    <?= $form->field($model, 'shopPhone')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'shopWeb')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'shopAddress')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'shopCostMin')->textInput() ?>

    <?= $form->field($model, 'shopCostMax')->textInput() ?>

    <?= $form->field($model, 'shopMiddleCost')->dropDownList([ 1 => '1', 2 => '2', 3 => '3', 4 => '4', 5 => '5', ], ['prompt' => '']) ?>

    <?= $form->field($model, 'shopAgregator')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
