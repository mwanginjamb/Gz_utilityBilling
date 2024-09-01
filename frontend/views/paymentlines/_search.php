<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\PaymentlinesSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="paymentlines-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'paymentheader_id') ?>

    <?= $form->field($model, 'opening_water_readings') ?>

    <?= $form->field($model, 'closing_water_readings') ?>

    <?= $form->field($model, 'settled') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'update_at') ?>

    <?php // echo $form->field($model, 'created_by') ?>

    <?php // echo $form->field($model, 'updated_by') ?>

    <?php // echo $form->field($model, 'deleted') ?>

    <?php // echo $form->field($model, 'deleted_at') ?>

    <?php // echo $form->field($model, 'deleted_by') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
