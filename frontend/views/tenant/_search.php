<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\TenantSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="tenant-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'user_id') ?>

    <?= $form->field($model, 'principle_tenant_name') ?>

    <?= $form->field($model, 'house_number') ?>

    <?= $form->field($model, 'cell_number') ?>

    <?php // echo $form->field($model, 'billing_email_address') ?>

    <?php // echo $form->field($model, 'id_number') ?>

    <?php // echo $form->field($model, 'agreed_rent_payable') ?>

    <?php // echo $form->field($model, 'agreed_water_rate') ?>

    <?php // echo $form->field($model, 'has_signed_tenancy_agreement') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'update_at') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
