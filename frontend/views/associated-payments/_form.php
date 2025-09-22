<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\AssociatedPayments $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="associated-payments-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'paymentline_id')->textInput() ?>

    <?= $form->field($model, 'payment_description')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'payment_amount')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'created_at')->textInput() ?>

    <?= $form->field($model, 'updated_at')->textInput() ?>

    <?= $form->field($model, 'created_by')->textInput() ?>

    <?= $form->field($model, 'updated_by')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
