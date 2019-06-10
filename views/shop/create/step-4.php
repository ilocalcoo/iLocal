<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Shop */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="shop-form create-step">
    <div class="step_form-rectangle-wrap">
        <div class="step_form-rectangle step_form-rectangle_active"></div>
        <div class="step_form-rectangle step_form-rectangle_active"></div>
        <div class="step_form-rectangle step_form-rectangle_active"></div>
        <div class="step_form-rectangle step_form-rectangle_active"></div>
    </div>

    <h1 class="step_name">Шаг 4: Ценовая политика</h1>

    <?php $form = ActiveForm::begin(); ?>

    <div class="step-form-4_main-wrap">
        <div class="step-form-4_min-wrap">
            <div class="step-form-4_cost-min">
            <?= $form->field($model, 'shopCostMin', ['options' => ['class' => 'shop-create-form']])->textInput(['placeholder' => '50'])
                ->label('Минимальная цена <div>Средний чек на одного посетителя</div>') ?>
            <span>руб.</span>
            </div>
            <?= $form->field($model, 'shopMiddleCost', ['options' => ['class' => 'shop-create-form', 'de']])->radioList(
                app\models\Shop::SHOP_MIDDLE_COST_LABELS,
                [
                    'item' => function ($index, $label, $name, $checked, $value) {
                        $check = $checked ? ' checked="checked"' : '';
                        $return = '<label class="shop-create_cost-radio-btn-wrap">';
                        $return .= '<input type="radio" name="' . $name . '" value="' . $value  . '" tabindex="3" ' .$check. '>';
                        $return .= '<div class="shop-create_cost-radio-btn">' . ucwords($label) . '</div>';
                        $return .= '</label>';
                        return $return;
                    }
                ]
            ) ?>
        </div>
        <div class="step-form-4_max-wrap">
        <div class="step-form-4_cost-max">
            <?= $form->field($model, 'shopCostMax', ['options' => ['class' => 'shop-create-form']])->textInput(['placeholder' => '5000'])
                ->label('Максимальная цена <div>Средний чек на одного посетителя</div>') ?>
            <span>руб.</span>
        </div>
            <?= $form->field($model, 'shopLinkPdf', ['options' => ['class' => 'shop-create-form']])->textInput(['placeholder' => 'https://yadi.sk/d/ExEmpl'])
                ->label('Добавить ссылку на pdf <div>Меню, расписание, услуги</div>') ?>
        </div>
    </div>
    <div class="step_form-line"></div>
    <div class="form-group step_form-rectangle_btn-wrap">
        <a class="step_form-rectangle_btn-back" href="http://ilocaldev/shops/<?= $model->shopId ?>/update/address"><
            Назад</a>
        <button type="submit" class="step_form-rectangle_btn-next">Разместить</button>
    </div>

    <?php ActiveForm::end(); ?>

</div>
