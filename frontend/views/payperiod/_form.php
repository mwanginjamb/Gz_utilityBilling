<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var common\models\Payperiod $model */
/** @var yii\widgets\ActiveForm $form */

$date = 'Rent Period Ending ' . date('M, Y');
?>

<div class="row my-3">
    <div class="col">
        <div class="paymentheader-actions">
            <?= (!$model->isNewRecord && $model->payperiodstatus->name == 'Open') ? Html::a(Yii::t('app', 'Close Pay period'), ['close'], [
                'class' => 'btn btn-warning',
                'data' => [
                    'confirm' => Yii::t('app', 'Are you sure you want to close this pay period ?'),
                    'params' => [
                        'id' => $model->id
                    ],
                    'method' => 'post',
                ],
            ]) : '' ?>
            <?= (!$model->isNewRecord && !$paymentheader || array_key_exists('paymentlines', $paymentheader)) ? Html::a(Yii::t('app', 'Generate Payment Header'), ['generate-header'], [
                'class' => 'btn btn-info',
                'data' => [
                    'confirm' => Yii::t('app', 'Are you sure you want to generate payment header for this pay period?'),
                    'params' => [
                        'payperiod' => $model->id,
                        'property' => $model->property_id
                    ],
                    'method' => 'post',
                ],
            ]) : '' ?>
            <?= (!$model->isNewRecord && ($paymentheader && is_array($paymentheader['paymentlines'])) && $model->payperiodstatus->name == 'Open') ? Html::a(Yii::t('app', 'Invoice Tenants'), ['invoice'], [
                'class' => 'btn btn-success',
                'data' => [
                    'confirm' => Yii::t('app', 'Are you sure you want to Invoice tenants in this property for this pay period ?'),
                    'params' => [
                        'id' => $model->id
                    ],
                    'method' => 'post',
                ],
            ]) : '' ?>

        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-4 col">
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

    </div>
    <div class="col-md-8 col">
        <?php if ($paymentheader && is_array($paymentheader['paymentlines'])): ?>




            <table class="table table-bordered" id="paymentlines">
                <thead>
                    <tr>

                        <td class="info text-bold">Tenant Name</td>
                        <td class="info text-bold">Rent</td>
                        <td class="info text-bold">Water Rate/Unit</td>
                        <td class="info text-info text-bold">Opening Water Reading</td>
                        <td class="info text-info text-bold">Closing Water Reading</td>
                        <td class="info text-bold">Units Consumed</td>
                        <td class="info text-bold">Water Bill</td>
                        <td>Action</td>
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
                            <td><?= Yii::$app->formatter->asCurrency($line->agreed_rent_payable, 'Ksh.') ?></td>
                            <td><?= $line->agreed_water_rate ?></td>
                            <td data-key="<?= $line->id ?>" data-name="opening_water_readings"
                                class="opening_water_readings text-info" data-service="<?= $endpoint ?>"
                                ondblclick="addInput(this,'number')">
                                <?= $line->opening_water_readings ?>
                            </td>
                            <td data-key="<?= $line->id ?>" data-name="closing_water_readings"
                                class="closing_water_readings text-info" data-service="<?= $endpoint ?>"
                                ondblclick="addInput(this,'number')" data-validate="water_bill">
                                <?= $line->closing_water_readings ?>
                            </td>
                            <td><?= $line->units_used ?></td>
                            <td data-name="water_bill" class="water_bill">
                                <?= Yii::$app->formatter->asCurrency($line->water_bill, 'Ksh.') ?>
                            </td>

                            <td>
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
                            </td>

                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <div class="alert alert-info">Payment Lines are yet to be Generated for this Pay Period.</div>
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