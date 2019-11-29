<?php

use app\models\Shop;
use app\models\ThumbGenerator;
use kartik\date\DatePicker;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Event */
/* @var $form yii\widgets\ActiveForm */
$eventOwner = Shop::find()
    ->select('shopShortName')
    ->where(['=', 'creatorId', Yii::$app->user->id])
    ->indexBy('shopId')
    ->column();
?>

<div class="event-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <?= $form->field($model, 'creatorId')->hiddenInput(['value'=>Yii::$app->user->id])->label(false) ?>

    <div class="row">
        <div class="col-md-6 col-12">
            <label class="control-label">Место</label>
            <?= $form->field($model, 'eventOwnerId', ['options' => ['class' => 'shop-create-form select']])->dropDownList($eventOwner)
                ->label(false) ?>

            <?= $form->field($model, 'eventTypeId', ['options' => ['class' => 'shop-create-form']])->radioList(
                app\models\EventType::TYPES_LABELS,
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
                <?php if (empty($model->eventPhotos)) {
                   echo 'Нет загруженных фотографий';
                }?>
            <?php foreach ($model->eventPhotos as $photo) { ?>
                <div class="shop-form_shop-photos">
                    <?= Html::img('/img/eventPhoto/'
                        . $model->id . '/'
                        . ThumbGenerator::getSizeDir('small') .'/'
                        . ($photo['eventPhoto']), ['class' => 'shop-form_photo']) ?>
                    <?= Html::a(Html::img('/img/shop/photo_delete.svg'), ['/event-photo/delete', 'id' => $photo['id']], [
                        'class' => 'shop-form_photo-delete',
                        'data' => [
                            'confirm' => 'Вы уверены что хотите удалить фотографию?'
                        ],
                    ]) ?>
                </div>
            <?php } ?>
            </div>

            <?= $form->field($model, 'uploadedEventPhoto[]')
                ->fileInput(['multiple' => true, 'accept' => 'image/*'])->label('Изображение')
                ->hint('Прикрепите фото') ?>

            <?= $form->field($model, 'begin', ['options' => ['class' => 'shop-create-form']])->widget(DatePicker::classname(),[
                'name' => 'dp_1',
                'type' => DatePicker::TYPE_INPUT,
                'value' => date('d.m.Y'),
                'pluginOptions' => [
                    'autoclose'=>true,
                    'format' => 'dd.mm.yyyy'
                ]
            ])->textInput(['placeholder' => date('d.m.Y')]) ?>

            <?= $form->field($model, 'end', ['options' => ['class' => 'shop-create-form']])->widget(DatePicker::classname(),[
                'name' => 'dp_2',
                'type' => DatePicker::TYPE_INPUT,
                'value' => date('d.m.Y'),
                'pluginOptions' => [
                    'autoclose'=>true,
                    'format' => 'dd.mm.yyyy'
                ]
            ])->textInput(['placeholder' => date('d.m.Y')]) ?>
        </div>
        <div class="col-md-6 col-12"><?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'fullDesc')->textarea(['rows' => 6]) ?>

            <div class="row">
                <div class="col-md-3 col-12 offset-md-4">
                    <div class="form-group text-center">
                        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-outline-coral w-100']) ?>
                    </div>
                </div>
            </div></div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
