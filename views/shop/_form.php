<?php

use yii\bootstrap4\Modal;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Shop */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="shop-form">

    <?php $form = ActiveForm::begin(); ?>
    <?= $form->field($model, 'creatorId')
        ->hiddenInput(['value'=>Yii::$app->user->id])
        ->label(false) ?>

    <div class="row">
        <div class="col-md-6 col-12">
            <?= $form->field($model, 'shopShortName', ['options' => ['class' => 'shop-create-form']])
                ->textInput(['maxlength' => true, 'placeholder' => 'Введите название места (не более 38 симв.)'])
                ->label('Название') ?>

            <?= $form->field($model, 'shopShortDescription', ['options' => ['class' => 'shop-create-form']])
                ->textInput(['maxlength' => true, 'placeholder' => 'Краткое описание места (не более 186 симв.)'])
                ->label('Подзаголовок') ?>

            <?= $form->field($model, 'shopFullDescription', ['options' => ['class' => 'shop-create-form']])
                ->textInput(['maxlength' => true, 'placeholder' => 'Полное описание места'])
                ->label('Описание') ?>

            <?= $form->field($model, 'shopTypeId', ['options' => ['class' => 'shop-create-form']])
                ->radioList(app\models\ShopType::TYPES_LABELS,
                [
                    'item' => function ($index, $label, $name, $checked, $value) {
                        $check = $checked ? ' checked="checked"' : '';
                        $return = '<label class="shop-create_type-radio-btn-wrap">';
                        $return .= '<input type="radio" name="' . $name . '" value="' . $value . '" tabindex="3" ' .$check. '>';
                        $return .= '<span class="shop-create_type-radio-btn">' . ucwords($label) . '</span>';
                        $return .= '</label>';
                        return $return;
                    }
                ]
            )->label('Категория') ?>

            <?= $form->field($model, 'uploadedShopPhoto[]')->fileInput(['multiple' => true, 'accept' => 'image/*'])->label('Изображение')
                ->hint('Прикрепите от 1 до 10 файлов') ?>
        </div>
        <div class="col-md-6 col-12">
            <?php
            Modal::begin([
                'size' => 'modal-lg',
                'toggleButton' => [
                    'label' => $form->field($model, 'shopAddressId')
                        ->textInput(['maxlength' => true, 'placeholder'=>'Введите адрес']),
                    'tag' => 'a',
                    'class' => '',
                    'type' => '',
                ],
                'closeButton' => [
                    'class' => 'btn btn-coral',
                    'label' => 'Выбрать / Закрыть'
                ]
            ]);
            ?>
            <div class="modal-body">
                <div id="profile_map"></div>
            </div>
            <?php Modal::end(); ?>
            <?= $form->field($model, 'shopAddressId')->textInput() ?>
            <input type="hidden" name="coords_address" id="coords_address" value="">
            <input type="hidden" id="input_address" value="">

            <?= $form->field($model, 'shopPhone', ['options' => ['class' => 'shop-create-form']])
                ->textInput(['maxlength' => true, 'placeholder' => '+7(000)000 00 00'])
                ->label('Телефон') ?>
            <?= $form->field($model, 'shopWeb', ['options' => ['class' => 'shop-create-form']])
                ->textInput(['maxlength' => true, 'placeholder' => 'www.example.ru'])
                ->label('Сайт') ?>

            <?= $form->field($model, 'shopMiddleCost', ['options' => ['class' => 'shop-create-form']])
                ->dropDownList([ 1 => '1', 2 => '2', 3 => '3', 4 => '4', 5 => '5', ], ['prompt' => ''])
                ->label('Средний чек') ?>
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-md-3 col-12 offset-md-4">
            <div class="form-group text-center">
                <?= Html::submitButton('Сохранить', ['class' => 'btn btn-outline-coral w-100']) ?>
            </div>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
