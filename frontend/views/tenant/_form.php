<?php

use yii\bootstrap5\Html;
use yii\bootstrap5\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\Tenant $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="tenant-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php // $form->field($model, 'user_id')->textInput() ?>

    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'principle_tenant_name')->textInput(['maxlength' => true]) ?>

        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'house_number')->dropDownList($units, ['prompt' => 'select ...']) ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'cell_number')->textInput(['maxlength' => true]) ?>

        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'billing_email_address')->textInput(['maxlength' => true, 'type' => 'email']) ?>

        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'id_number')->textInput(['maxlength' => true]) ?>

        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'agreed_rent_payable')->textInput(['type' => 'number']) ?>

        </div>
    </div>
    <div class="row">
        <div class="col-md-6">

            <?= $form->field($model, 'agreed_water_rate')->textInput(['type' => 'number']) ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'service_charge')->textInput(['type' => 'number']) ?>

        </div>
    </div>
    <div class="row">
        <div class="col-md-6">

        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'has_signed_tenancy_agreement')->checkbox() ?>

        </div>
    </div>











    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>