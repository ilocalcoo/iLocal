<?php

use yii\widgets\ActiveForm;
$this->registerCssFile('/css/event/create/form.css');
/* @var $this yii\web\View */
/* @var $model app\models\Event */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="shop-form create-step">
    <div class="step_form-rectangle-wrap">
        <div class="step_form-rectangle step_form-rectangle_active"></div>
        <div class="step_form-rectangle step_form-rectangle_active"></div>
        <div class="step_form-rectangle"></div>
    </div>

    <h1 class="step_name">Шаг 2: Добавьте название акции, ее описание и сроки</h1>

    <?php $form = ActiveForm::begin(); ?>

    <div class="step_form-event-name-wrap">
    <?= $form->field($model, 'title', ['options' => ['class' => 'shop-create-form']])->textInput()
        ->label('Название акции <div>Название акции не должно превышать 38 знаков</div>') ?>

    <?= $form->field($model, 'begin', ['options' => ['class' => 'shop-create-form']])->textInput(['placeholder' => 'ДД.ММ.ГГГГ']) ?>

    <?= $form->field($model, 'end', ['options' => ['class' => 'shop-create-form']])->textInput(['placeholder' => 'ДД.ММ.ГГГГ']) ?>
    </div>
    <?= $form->field($model, 'shortDesc', ['options' => ['class' => 'shop-create-form']])->textarea()
        ->label('Краткое описание акции <div>Краткое описание акции не должно превышать 172 знака</div>') ?>

    <?= $form->field($model, 'fullDesc', ['options' => ['class' => 'shop-create-form']])->textarea() ?>


    <div class="step_form-line"></div>

    <div class="form-group step_form-rectangle_btn-wrap">
        <a class="step_form-rectangle_btn-back" href="/event/create?id=<?= $model->id ?>">< Назад</a>
        <button type="submit" class="step_form-rectangle_btn-next">Далее ></button>
    </div>


    <?php ActiveForm::end(); ?>

</div>
