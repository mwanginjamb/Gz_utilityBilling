<?php

use common\models\Property;
use common\models\Tenant;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\Unit $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="unit-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'unit_name')->textInput(['maxlength' => true]) ?>

    <?php //$form->field($model, 'tenant_id')->dropDownList(ArrayHelper::map(Tenant::find()->all(), 'id', 'principle_tenant_name'), ['prompt' => 'Select ...']) ?>

    <?= $form->field($model, 'property_id')->dropDownList(ArrayHelper::map(Property::find()->all(), 'id', 'name'), ['prompt' => 'Select ...']) ?>

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