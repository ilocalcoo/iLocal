<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\search\ShopSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="shop-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <?= $form->field($model, 'shopId') ?>

    <?= $form->field($model, 'shopShortName') ?>

    <?= $form->field($model, 'shopFullName') ?>

    <?= $form->field($model, 'shopPhoto') ?>

    <?= $form->field($model, 'shopType') ?>

    <?php // echo $form->field($model, 'shopPhone') ?>

    <?php // echo $form->field($model, 'shopWeb') ?>

    <?php // echo $form->field($model, 'shopAddress') ?>

    <?php // echo $form->field($model, 'shopCostMin') ?>

    <?php // echo $form->field($model, 'shopCostMax') ?>

    <?php // echo $form->field($model, 'shopMiddleCost') ?>

    <?php // echo $form->field($model, 'shopAgregator') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
