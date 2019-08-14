<?php

use yii\helpers\Html;
use yii\web\User;
use yii\widgets\ActiveForm;

$this->registerCssFile('/css/event/create/form.css');
/* @var $this yii\web\View */
/* @var $model app\models\Happening */
/* @var $form yii\widgets\ActiveForm */
/* @var $eventOwner array */
/**
 * @var $userId integer
 */
?>

<div class="shop-form create-step">
    <div class="step_form-rectangle-wrap">
        <div class="step_form-rectangle step_form-rectangle_active"></div>
        <div class="step_form-rectangle"></div>
        <div class="step_form-rectangle"></div>
    </div>

    <h1 class="step_name">Шаг 1: Выберите владельца и категорию акции</h1>

    <?php $form = ActiveForm::begin(); ?>
    <?= $form->field($model, 'creatorId')->hiddenInput(['value' => $userId])->label(false) ?>
    <?= $form->field($model, 'shopId', ['options' => ['class' => 'shop-create-form']])->dropDownList($eventOwner)
        ->label('Выберите наименование владельца акции') ?>

    <?= $form->field($model, 'happeningTypeId', ['options' => ['class' => 'shop-create-form']])->radioList(
        app\models\HappeningType::TYPES_LABELS,
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
