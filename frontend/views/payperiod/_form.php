<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\Payperiod $model */
/** @var yii\widgets\ActiveForm $form */


?>



<div class="row">
    <div class="col-md-4 col">
        <div class="payperiod-form">
            <?php $form = ActiveForm::begin(); ?>
            <?= $form->errorSummary($model) ?>

            <?= $form->field($model, 'period')->textInput(['type' => 'date']) ?>

            <?= $form->field($model, 'body')->textarea(['rows' => 3]) ?>

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

    </div>
    <div class="col-md-8 col">
        <?php if ($paymentheader && is_array($paymentheader['paymentlines'])): ?>
            <div class="table-responsive">
                <table class="table table-bordered" id="paymentlines">
                    <thead>
                        <tr>

                            <td class="info text-bold">Tenant Name</td>
                            <?php if ($model->property->billing_type == 'rent' || $model->property->billing_type == 'composite'): ?>
                                <td class="info text-bold">Rent</td>
                            <?php endif; ?>
                            <?php if ($model->property->billing_type == 'utility' || $model->property->billing_type == 'composite'): ?>
                                <td class="info text-bold">Water Rate/Unit</td>
                                <td class="info text-info text-bold">Opening Water Reading</td>
                                <td class="info text-info text-bold">Closing Water Reading</td>
                                <td class="info text-bold">Units Consumed</td>
                                <td class="info text-bold">Water Bill</td>
                            <?php endif; ?>
                            <?php if ($model->property->billing_type == 'service_charge' || $model->property->billing_type == 'composite'): ?>
                                <td class="info text-bold">Service Charge</td>
                            <?php endif; ?>

                            <!-- <td>Action</td> -->
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($paymentheader['paymentlines'] as $line):
                            $line = (object) $line;
                            $class = ($line->invoiced === NULL) ? 'text' : 'text-danger';
                            $endpoint = Url::home(true) . 'apiv1/invoicelines/' . $line->id
                                ?>
                            <tr class="<?= $class ?>">

                                <td><?= $line->tenant_name ?></td>
                                <?php if ($model->property->billing_type == 'rent' || $model->property->billing_type == 'composite'): ?>
                                    <td><?= Yii::$app->formatter->asCurrency($line->agreed_rent_payable, 'Ksh.') ?></td>
                                <?php endif; ?>

                                <?php if ($model->property->billing_type == 'utility' || $model->property->billing_type == 'composite'): ?>
                                    <td><?= $line->agreed_water_rate ?></td>
                                    <td data-key="<?= $line->id ?>" data-name="opening_water_readings"
                                        class="opening_water_readings text-info" data-service="<?= $endpoint ?>"
                                        ondblclick="addInput(this,'number')">
                                        <?= $line->opening_water_readings ?>
                                    </td>
                                    <td data-key="<?= $line->id ?>" data-name="closing_water_readings" data-reload="1"
                                        class="closing_water_readings text-info" data-service="<?= $endpoint ?>"
                                        ondblclick="addInput(this,'number')" data-validate="water_bill">
                                        <?= $line->closing_water_readings ?>
                                    </td>
                                    <td><?= $line->units_used ?></td>
                                    <td data-name="water_bill" class="water_bill">
                                        <?= Yii::$app->formatter->asCurrency($line->water_bill, 'Ksh.') ?>
                                    </td>
                                <?php endif; ?>
                                <?php if ($model->property->billing_type == 'service_charge' || $model->property->billing_type == 'composite'): ?>
                                    <td data-name="service_charge" class="service_charge">
                                        <?= Yii::$app->formatter->asCurrency($line->service_charge, 'Ksh.') ?>
                                    </td>
                                <?php endif; ?>

                                <!-- <td>
                                    <?= ($line->invoiced === NULL) ? Html::a('<i class="fas fa-eye"></i> Update', Url::toRoute(['paymentlines/update', 'id' => $line->id], $schema = true), [
                                        'class' => 'btn btn-outline-primary btn-xs mx-1',
                                        'title' => 'Update Invoice Line',
                                        'data' => [
                                            'params' => [
                                                'id' => $line->id,
                                                'tenant' => $line->tenant_name,
                                            ],
                                            'method' => 'GET'
                                        ]

                                    ]) : ''; ?>
                                </td> -->

                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

        <?php else: ?>
            <div class="alert alert-info my-4">Payment Lines are yet to be Generated for this Pay Period.</div>
        <?php endif; ?>
    </div>
</div>

<?php

$script = <<<JS

$(function(){    
    $('#paymentlines').DataTable();
});


JS;

$this->registerJs($script);