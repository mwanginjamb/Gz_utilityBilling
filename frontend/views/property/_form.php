<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\Property $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="property-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'build_date')->textInput(['type' => 'date']) ?>

    <?php $form->field($model, 'created_at')->textInput() ?>

    <?php $form->field($model, 'updated_at')->textInput() ?>

    <?php $form->field($model, 'created_by')->textInput() ?>

    <?php $form->field($model, 'updated_by')->textInput() ?>

    <?= $form->field($model, 'billing_type')->dropDownList([
        'composite' => 'composite (rent, utilities, service charge)',
        'service_charge' => 'Service Charge Only',
        'rent' => 'rent Only',
        'utilities' => 'Utilities Only'
    ]) ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>