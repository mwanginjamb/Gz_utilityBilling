<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\Paymentlines $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class=" paymentlines-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'paymentheader_id')->hiddenInput()->label(false) ?>

    <?= $form->field($model, 'opening_water_readings')->textInput(['type' => 'number']) ?>

    <?= $form->field($model, 'closing_water_readings')->textInput(['type' => 'number']) ?>

    <?php $form->field($model, 'settled')->textInput() ?>

    <?php $form->field($model, 'created_at')->textInput() ?>

    <?php $form->field($model, 'update_at')->textInput() ?>

    <?php $form->field($model, 'created_by')->textInput() ?>

    <?php $form->field($model, 'updated_by')->textInput() ?>

    <?php $form->field($model, 'deleted')->textInput() ?>

    <?php $form->field($model, 'deleted_at')->textInput() ?>

    <?php $form->field($model, 'deleted_by')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>