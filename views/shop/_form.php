<?php

use app\models\ThumbGenerator;
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
                ->textInput(['maxlength' => true, 'placeholder' => 'Введите короткое название места (не более 38 симв.)'])
                ->label('Короткое название') ?>

            <?= $form->field($model, 'shopFullName', ['options' => ['class' => 'shop-create-form']])
                ->textInput(['maxlength' => true, 'placeholder' => 'Введите полное название места (не более 186 симв.)'])
                ->label('Полное название') ?>

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
        </div>
        <div class="col-md-6 col-12">
            <div class="shop-form_shop-photos-wrap">
                <?php if (empty($model->shopPhotos)) {
                    echo 'Нет загруженных фотографий';
                }?>
                <?php foreach ($model->shopPhotos as $photo) { ?>
                    <div class="shop-form_shop-photos">
                        <?= Html::img('/img/shopPhoto/'
                            . $model->shopId . '/'
                            . ThumbGenerator::getSizeDir('small') .'/'
                            . ($photo['shopPhoto']), ['class' => 'shop-form_photo']) ?>
                        <?= Html::a(Html::img('/img/shop/photo_delete.svg'), ['/shop-photo/delete', 'id' => $photo['id']], [
                            'class' => 'shop-form_photo-delete',
                            'data' => [
                                'confirm' => 'Вы уверены что хотите удалить фотографию?'
                            ],
                        ]) ?>
                    </div>
                <?php } ?>
            </div>
            <?= $form->field($model, 'uploadedShopPhoto[]')
                ->fileInput(['multiple' => true, 'accept' => 'image/*'])
                ->label('Изображение')
                ->hint('Прикрепите от 1 до 10 файлов') ?>
            <?php
            Modal::begin([
                'size' => 'modal-lg',
                'toggleButton' => [
                    'label' => '<div class="shop-create-form has-success">
                                    <label class="control-label" for="input_address">Адрес</label>
                                    <input type="text" id="input_address" name="input_address" class="form-control" 
                                    value="'.
                        (is_object($model->shopAddress) ?
                        ($model->shopAddress->city.','.$model->shopAddress->street.','.$model->shopAddress->houseNumber)
                        : '')
                            .'" 
                                    placeholder="Введите адрес" aria-invalid="false" style="color: rgb(254, 138, 128);">
                                    <div class="help-block"></div>
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
            <input type="hidden" name="coords_address" id="coords_address" value="<?=(is_object($model->shopAddress) ? ($model->shopAddress->latitude.','.$model->shopAddress->longitude) : '') ?>">

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
