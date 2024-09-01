<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\Paymentheader $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="paymentheader-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'payperiod_id')->textInput() ?>

    <?= $form->field($model, 'property_id')->textInput() ?>

    <?= $form->field($model, 'created_at')->textInput() ?>

    <?= $form->field($model, 'update_at')->textInput() ?>

    <?= $form->field($model, 'created_by')->textInput() ?>

    <?= $form->field($model, 'updated_by')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
