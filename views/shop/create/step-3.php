<?php

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\widgets\Alert;

$this->registerCssFile('/css/shop/create/form.css');
\app\assets\ProfileMapsAsset::register($this);
/* @var $this yii\web\View */
/* @var $model app\models\Shop */
/* @var $shopAddress app\models\ShopAddress */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="shop-form create-step">
    <div class="step_form-rectangle-wrap">
        <div class="step_form-rectangle step_form-rectangle_active"></div>
        <div class="step_form-rectangle step_form-rectangle_active"></div>
        <div class="step_form-rectangle step_form-rectangle_active"></div>
        <div class="step_form-rectangle"></div>
    </div>

    <?= Alert::widget() ?>

    <h1 class="step_name">Шаг 3: Введите контактную информацию</h1>



    <span class="step-form-3_address-name">Адрес</span>
    <br>
    <?php
    $comma = '';
    foreach (ArrayHelper::toArray($model->shopAddress) as $key => $item) {
        if ($key == 'id' || $item == '') {
            continue;
        }
        if ($key == 'latitude') {
            $comma = '. Координаты: <span id="user_coordinates">';
        }
        echo $comma . $item;
        if ($key == 'longitude') {
            echo '</span>';
        }
        $comma = ', ';
    }
    ?>
    <br><br>

    <i>Выберите адрес на карте или воспользуйтесь поиском</i>
    <div id="profile_map"></div>

    <?= Html::beginForm(); ?>
    <?= Html::hiddenInput('address', '', ['id' => 'profile_address']); ?>
    <div class="form-group">
        <div class="text-center">
            <?= Html::submitButton('Сохранить адрес', ['class' => 'btn btn-primary']) ?>
        </div>
    </div>
    <?= Html::endForm(); ?>
    <br>


    <?php $form = ActiveForm::begin(); ?>

    <div class="step-form-3_main-wrap">
        <div class="step-form-3_address-wrap">
            <?= $form->field($shopAddress, 'city', ['options' => ['class' => 'shop-create-form_address shop-create-form']])->textInput(['placeholder' => 'Москва']) ?>
            <?= $form->field($shopAddress, 'street', ['options' => ['class' => 'shop-create-form_address shop-create-form']])->textInput(['placeholder' => 'Тверская']) ?>

            <div class="step-form-3_address-wrap_number">
                <?= $form->field($shopAddress, 'houseNumber', ['options' => ['class' => 'shop-create-form_address shop-create-form']])->textInput(['placeholder' => '1']) ?>
                <?= $form->field($shopAddress, 'housing', ['options' => ['class' => 'shop-create-form_address shop-create-form']])->textInput(['placeholder' => 'А']) ?>
                <?= $form->field($shopAddress, 'building', ['options' => ['class' => 'shop-create-form_address shop-create-form']])->textInput(['placeholder' => '1']) ?>
            </div>

            <?= $form->field($model, 'shopPhone', ['options' => ['class' => 'shop-create-form']])->textInput(['maxlength' => true, 'placeholder' => '+7']) ?>

            <?= $form->field($model, 'shopWorkTime', ['options' => ['class' => 'shop-create-form']])->textInput(['placeholder' => 'Пн-Пт: 8.00 - 18.00 Сб-Вс: 10.00 - 15.00']) ?>

            <?= $form->field($model, 'shopWeb', ['options' => ['class' => 'shop-create-form']])->textInput(['maxlength' => true, 'placeholder' => 'www.example.com']) ?>
        </div>
<!--        <div class="step-form-3_web-wrap">-->
<!---->
<!--            -->
<!--        </div>-->
    </div>
    <div class="step_form-line"></div>

    <div class="form-group step_form-rectangle_btn-wrap">
        <a class="step_form-rectangle_btn-back" href="/shops/<?= $model->shopId ?>/update/photo">< Назад</a>
        <button type="submit" class="step_form-rectangle_btn-next">Далее ></button>
    </div>

    <?php ActiveForm::end(); ?>

</div>
