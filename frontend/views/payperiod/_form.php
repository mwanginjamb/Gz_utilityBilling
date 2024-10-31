<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\Payperiod $model */
/** @var yii\widgets\ActiveForm $form */

$date = 'Rent Period Ending ' . date('M, Y');
?>

<div class="payperiod-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'period')->textInput(['type' => 'date']) ?>

    <?= $form->field($model, 'body')->textarea(['rows' => 3, 'value' => $date]) ?>

    <?= $form->field($model, 'property_id')->dropDownList($properties, ['prompt' => 'Select ..']) ?>

    <?= (!$model->isNewRecord) ? $form->field($model, 'payperiodstatus_id')->dropDownList($payperiodstatus, ['prompt' => 'Select ...']) : '' ?>

    <?php $form->field($model, 'created_at')->textInput() ?>

    <?php $form->field($model, 'update_at')->textInput() ?>

    <?php $form->field($model, 'created_by')->textInput() ?>

    <?php $form->field($model, 'updated_by')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>