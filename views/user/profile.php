<?php

use app\assets\ProfileMapsAsset;
use app\models\User;
use yii\bootstrap4\Modal;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 * @var $model User
 * @var $form yii\widgets\ActiveForm
 */
ProfileMapsAsset::register($this);
$this->title = $title ?? 'I\'m Local';
?>
<div class="container">
    <h1 class="h3">Профиль</h1>
    <h2 class="h4">Личные данные</h2>

    <div class="row">
        <div class="col-md-6 col-12">
            <?php $form = ActiveForm::begin(); ?>
            <?= $form->field($model, 'lastName', ['options' => ['class' => 'shop-create-form']])
                ->textInput(['maxlength' => true, 'placeholder' => 'Введите Вашу фамилию'])
                ->label('Фамилия') ?>

            <?= $form->field($model, 'firstName', ['options' => ['class' => 'shop-create-form']])
                ->textInput(['maxlength' => true, 'placeholder' => 'Введите Ваше имя'])
                ->label('Имя') ?>

            <?= $form->field($model, 'middleName', ['options' => ['class' => 'shop-create-form']])
                ->textInput(['maxlength' => true, 'placeholder' => 'Введите Ваше отчество'])
                ->label('Отчество') ?>
            <br>
            <div class="form-group text-center">
                <?= Html::submitButton('Сохранить', ['class' => 'btn btn-outline-coral w-50']) ?>
            </div>
            <?= $form->field($model, 'id')
                ->hiddenInput(['value'=>$model->id, 'class' => ''])
                ->label(false) ?>
            <?php ActiveForm::end(); ?>
        </div>
        <div class="col-md-6 col-12">
            <?php $form = ActiveForm::begin(); ?>
            <?php
            Modal::begin([
                'size' => 'modal-lg',
                'toggleButton' => [
                    'label' => '<div class="shop-create-form has-success">
                                    <label class="control-label" for="input_address">Адрес</label>
                                    <input type="text" id="input_address" name="input_address" class="form-control" value="'
                                    .($model->userAddressId ?
                                        $model->userAddress->city
                                        . ', ' . $model->userAddress->street
                                        . ', ' . $model->userAddress->houseNumber
                                    : '')
                                    .'" placeholder="Введите адрес" aria-invalid="false">
                                    <span class="input-label-right" style="right: 28px;top: 40px;"><i class="fas fa-chevron-right"></i></span>
                                </div>',
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
            <input type="hidden" name="coords_address" id="coords_address" value="<?= $model->userAddress->latitude . ',' . $model->userAddress->longitude ?>">
            <br>
            <div class="form-group text-center">
                <?= Html::submitButton('Сохранить', ['class' => 'btn btn-outline-coral w-50']) ?>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>

</div>


