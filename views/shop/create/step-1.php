<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->registerCssFile('/css/shop/create/form.css');
/* @var $this yii\web\View */
/* @var $model app\models\Shop */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="shop-form create-step">
    <div class="step_form-rectangle-wrap">
        <div class="step_form-rectangle step_form-rectangle_active"></div>
        <div class="step_form-rectangle"></div>
        <div class="step_form-rectangle"></div>
        <div class="step_form-rectangle"></div>
    </div>

    <h1 class="step_name">Шаг 1: Введите название, описание и категорию места</h1>

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'shopShortName', ['options' => ['class' => 'shop-create-form']])->textInput(['maxlength' => true])
        ->label('Название места <div>Название места не должно превышать 75 знаков</div>') ?>

    <?= $form->field($model, 'shopShortDescription', ['options' => ['class' => 'shop-create-form']])->textarea()
        ->label('Краткое описание места <div>Краткое описание места не должно превышать 255 знаков</div>') ?>

    <?= $form->field($model, 'shopFullDescription', ['options' => ['class' => 'shop-create-form']])->textarea()
        ->label('Полное описание места <div>Напишите подробно обо всем, что выгодно отличает Ваше место от конкурентов (не более 1500 знаков)</div>') ?>

    <?= $form->field($model, 'shopTypeId', ['options' => ['class' => 'shop-create-form']])->radioList(
        app\models\ShopType::TYPES_LABELS,
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
    )->label('Выберите категорию <div>Для выбора доступна только одна категория</div>') ?>

    <div class="step_form-line"></div>

    <div class="form-group step_form-rectangle_btn-wrap">
        <a class="step_form-rectangle_btn-back" href="/shops">
            <span class="keyboard_arrow_left"></span> Назад</a>
        <button type="submit" class="step_form-rectangle_btn-next">Далее
            <img src="/img/shop/createShopBtn/keyboard_arrow_right_24px.svg" alt=""></button>
    </div>

    <?php ActiveForm::end(); ?>
</div>
