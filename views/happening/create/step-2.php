<?php

use kartik\datetime\DateTimePicker;
use yii\widgets\ActiveForm;
$this->registerCssFile('/css/event/create/form.css');
/* @var $this yii\web\View */
/* @var $model app\models\Happening */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="shop-form create-step">
    <div class="step_form-rectangle-wrap">
        <div class="step_form-rectangle step_form-rectangle_active"></div>
        <div class="step_form-rectangle step_form-rectangle_active"></div>
        <div class="step_form-rectangle"></div>
    </div>

    <h1 class="step_name">Шаг 2: Добавьте название события, его описание и дату начала</h1>

        <?php $form = \yii\bootstrap4\ActiveForm::begin(); ?>
            <?= $form->field($model, 'title', ['options' => ['class' => 'form-group shop-create-form']])->textInput(['options' => ['class' => 'form-control']])
                ->label('Название события <div>Название события не должно превышать 150 знаков</div>') ?>
            <?= $form->field($model, 'begin', ['options' => ['class' => 'form-group shop-create-form']])->widget(DateTimePicker::class, [
                'options' => [
                    'value' => (!$model->begin) ? date('Y-m-d H:i') : $model->begin,
                    'class' => 'form-control'
                ],
                'pluginOptions' => [
                    'startDate' => date('Y-m-d H:i'),
                    'format' => 'yyyy-mm-dd hh:ii',
                    'autoclose' => true,
                    'todayHighlight' => true
                ]
            ]); ?><br>
            <?= $form->field($model, 'price', ['options' => ['class' => 'form-group shop-create-form']])->textInput(['options' => ['class' => 'form-control']])
                ->label('Стоимость билета (входа) на событие <div>Можно оставить пустым, если бесплатно</div>') ?>

    <?= $form->field($model, 'description', ['options' => ['class' => 'shop-create-form']])->textarea()
        ->label('Описание события') ?>



    <div class="step_form-line"></div>

    <div class="form-group step_form-rectangle_btn-wrap">
        <a class="step_form-rectangle_btn-back" href="/happening/create?id=<?= $model->id ?>">< Назад</a>
        <button type="submit" class="step_form-rectangle_btn-next">Далее ></button>
    </div>


    <?php \yii\bootstrap4\ActiveForm::end(); ?>

</div>
