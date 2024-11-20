<?php
use yii\helpers\Url;
use yii\bootstrap5\Html;

?>

<div class="card">
    <div class="card-header">
        <div class="card-title">
            <h2>Current Tenants</h2>
        </div>
        <div class="card-tools">
            <?= Html::a(Yii::t('app', '<i class="fas fa-plus"></i> Add Unit'), ['unit/create', 'property' => $model->id], ['class' => 'btn btn-success']) ?>
            <?= Html::a(Yii::t('app', '<i class="fas fa-plus"></i> Add Billing Period'), ['payperiod/create'], [
                'class' => 'btn btn-primary',
                'target' => '_blank',
                'title' => 'Add Pay/ Billing Period Period',
                'data' => [
                    'params' => [
                        'property' => $model->id
                    ],
                    'method' => 'GET',
                ],
            ]) ?>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">

            <table class="table table-bordered" id="tenants">
                <thead>
                    <tr>
                        <td class="text-bold">Unit</td>
                        <td class="text-bold text-info">Principal Member</td>
                        <td class="text-bold text-info">Cell Number</td>
                        <td class="text-bold text-info">Billing Address</td>
                        <?php if ($model->billing_type == 'composite' || $model->billing_type == 'rent'): ?>
                            <td class="text-bold text-info">Rent Payable</td>
                        <?php endif; ?>
                        <td class="text-bold text-info">Service Charge</td>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Yii::$app->utility->printrr($occupiedUnits);
                    if ($occupiedUnits && count($occupiedUnits)):
                        foreach ($occupiedUnits as $ou):
                            $unit = (object) $ou;
                            $endpoint = Url::home(true) . 'apiv1/tenants/' . $unit->tenant['id']
                                ?>
                            <tr>
                                <td><?= $unit->unit_name ?></td>
                                <td data-name="principle_tenant_name" class="principle_tenant_name text-info"
                                    data-service="<?= $endpoint ?>" ondblclick="addInput(this)">
                                    <?= Html::a($unit->tenant['principle_tenant_name'], [Url::toRoute(['tenant/view', 'id' => $unit->tenant['id']])]) ?>
                                </td>
                                <td data-name="cell_number" class="cell_number text-info" data-service="<?= $endpoint ?>"
                                    ondblclick="addInput(this)">
                                    <?= $unit->tenant['cell_number'] ?>
                                </td>
                                <td data-name="billing_email_address" class="billing_email_address text-info"
                                    data-service="<?= $endpoint ?>" ondblclick="addInput(this,'email')">
                                    <?= $unit->tenant['billing_email_address'] ?>
                                </td>
                                <?php if ($model->billing_type == 'composite' || $model->billing_type == 'rent'): ?>
                                    <td data-name="agreed_rent_payable" class="agreed_rent_payable text-info"
                                        data-service="<?= $endpoint ?>" ondblclick="addInput(this,'number')">
                                        <?= Yii::$app->formatter->asCurrency($unit->tenant['agreed_rent_payable'], 'Ksh.') ?>
                                    </td>
                                <?php endif; ?>
                                <td data-name="service_charge" class="service_charge text-info" data-service="<?= $endpoint ?>"
                                    ondblclick="addInput(this,'number')">
                                    <?= $unit->tenant['service_charge'] ?>
                                </td>

                            </tr>
                        <?php endforeach;
                    endif;
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>