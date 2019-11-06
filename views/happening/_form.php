<?php

use app\models\Shop;
use app\models\ThumbGenerator;
use kartik\date\DatePicker;
use kartik\datetime\DateTimePicker;
use kartik\time\TimePicker;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\bootstrap4\Modal;

/* @var $this yii\web\View */
/* @var $model app\models\Event */
/* @var $form yii\widgets\ActiveForm */
$eventOwner = Shop::find()
    ->select('shopShortName')
    ->where(['=', 'creatorId', Yii::$app->user->id])
    ->indexBy('shopId')
    ->column();
//array_unshift($eventOwner, '— Не выбрано —');
$eventOwner[42000000] = '— Не выбрано —';
krsort($eventOwner);
?>

<div class="event-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'creatorId')->hiddenInput(['value'=>Yii::$app->user->id])->label(false) ?>

    <div class="row">
        <div class="col-md-6 col-12">

            <label class="control-label">Место <span class="text-gray"> — опционально</span></label>
            <?= $form->field($model, 'shopId', ['options' => ['class' => 'shop-create-form select']])
                ->dropDownList($eventOwner)
                ->label(false) ?>
            <?php
            Modal::begin([
                'size' => 'modal-lg',
                'toggleButton' => [
                    'label' => $form->field($model, 'address')
                        ->textInput(['maxlength' => true, 'placeholder'=>'Введите, если адрес не совпадает с местом']),
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

            <input type="hidden" name="coords_address" id="coords_address" value="<?= $model->latitude . ',' . $model->longitude ?>">

            <?= $form->field($model, 'happeningTypeId', ['options' => ['class' => 'shop-create-form']])->radioList(
                app\models\HappeningType::getNames(),
                [
                    'item' => function ($index, $label, $name, $checked, $value) {
                        $check = $checked ? ' checked="checked"' : '';
                        $return = '<label class="shop-create_type-radio-btn-wrap" style="padding:0;">';
                        $return .= '<input type="radio" name="' . $name . '" value="' . $value . '" tabindex="3" ' .$check. '>';
                        $return .= '<span class="shop-create_type-radio-btn">' . ucwords($label) . '</span>';
                        $return .= '</label>';
                        return $return;
                    }
                ]
            )->label('Категория') ?>

            <div class="shop-form_shop-photos-wrap">
                <?php if (empty($model->happeningPhotos)) {
                    echo 'Нет загруженных фотографий';
                }?>
                <?php foreach ($model->happeningPhotos as $photo) { ?>
                    <div class="shop-form_shop-photos">
                        <?= Html::img('/img/happeningPhoto/'
                            . $model->id . '/'
                            . ThumbGenerator::getSizeDir('small') .'/'
                            . ($photo['happeningPhoto']), ['class' => 'shop-form_photo']) ?>
                        <?= Html::a(Html::img('/img/shop/photo_delete.svg'), ['/happening-photo/delete', 'id' => $photo['id']], [
                            'class' => 'shop-form_photo-delete',
                            'data' => [
                                'confirm' => 'Вы уверены что хотите удалить фотографию?'
                            ],
                        ]) ?>
                    </div>
                <?php } ?>
            </div>
            <?= $form->field($model, 'uploadedHappeningPhoto[]')->fileInput(['multiple' => true, 'accept' => 'image/*'])->label('Изображение')
                ->hint('Прикрепите от 1 до 3 файлов') ?>
        </div>
        <div class="col-md-6 col-12">
            <?= $form->field($model, 'begin', ['options' => ['class' => 'shop-create-form']])->widget(DateTimePicker::classname(),[
                'name' => 'dp_1',
                'type' => DateTimePicker::TYPE_INPUT,
                'value' => date('Y-m-d H:i'),
                'pluginOptions' => [
                    'autoclose'=>true,
                    'format' => 'yyyy-mm-dd H:i'
                ]
            ])->textInput(['placeholder' => date('Y-m-d H:i')]) ?>
            <?= $form->field($model, 'end', ['options' => ['class' => 'shop-create-form']])->widget(DateTimePicker::classname(),[
                'name' => 'dp_1',
                'type' => DateTimePicker::TYPE_INPUT,
                'value' => date('Y-m-d H:i'),
                'pluginOptions' => [
                    'autoclose'=>true,
                    'format' => 'yyyy-mm-dd H:i'
                ]
            ])->textInput(['placeholder' => date('Y-m-d H:i')]) ?>
            <?= $form->field($model, 'price')->textInput(['maxlength' => true, 'placeholder'=>'Оставьте пустым, если вход свободный']) ?>

            <?= $form->field($model, 'title')->textInput([
                'maxlength' => true,
                'placeholder' => 'Введите название события (не более 30 симв.)',
            ]) ?>

            <?= $form->field($model, 'description')->textarea(['rows' => 6, 'placeholder'=>'Полное описание события']) ?>

            <div class="row">
                <div class="col-md-3 col-12 offset-md-4">
                    <div class="form-group text-center">
                        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-outline-coral w-100']) ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
