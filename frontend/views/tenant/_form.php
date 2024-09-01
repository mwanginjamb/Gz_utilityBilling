<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\Tenant $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="tenant-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'user_id')->textInput() ?>

    <?= $form->field($model, 'principle_tenant_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'house_number')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'cell_number')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'billing_email_address')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'id_number')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'agreed_rent_payable')->textInput() ?>

    <?= $form->field($model, 'agreed_water_rate')->textInput() ?>

    <?= $form->field($model, 'has_signed_tenancy_agreement')->textInput() ?>

    <?= $form->field($model, 'created_at')->textInput() ?>

    <?= $form->field($model, 'update_at')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
