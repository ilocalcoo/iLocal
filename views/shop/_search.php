<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\jui\AutoComplete;

/* @var $this yii\web\View */
/* @var $model app\models\search\ShopSearch */
/* @var $form yii\widgets\ActiveForm */
/* @var $shopShortNameData app\models\Shop */
?>

<div class="shop-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <?php // echo $form->field($model, 'shopId') ?>

    <?php // echo $form->field($model, 'shopActive') ?>

    <?php // echo $form->field($model, 'shopShortName') ?>

    <?= $form->field($model, 'shopShortName')->widget(
        AutoComplete::className(), [
        'clientOptions' => [
            'source' => $shopShortNameData,
            'minLength' => '2',
        ],
        'options'=>[
            'class'=>'form-control'
        ]
    ])->label('Search'); ?>

    <?php // echo $form->field($model, 'shopPhoto') ?>

    <?php // echo $form->field($model, 'shopTypeId') ?>

    <?php // echo $form->field($model, 'shopPhone') ?>

    <?php // echo $form->field($model, 'shopWeb') ?>

    <?php // echo $form->field($model, 'shopAddressId') ?>

    <?php // echo $form->field($model, 'shopCostMin') ?>

    <?php // echo $form->field($model, 'shopCostMax') ?>

    <?php // echo $form->field($model, 'shopMiddleCost') ?>

    <?php // echo $form->field($model, 'shopAgregator') ?>

    <?php // echo $form->field($model, 'shopStatusId') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?php // Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
