<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var common\models\Tenant $model */

$this->title = $model->id . ' - ' . $model->principle_tenant_name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Tenants'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="card tenant-view">
    <div class="card-header">
        <h1 class="card-title"><?= Html::encode($this->title) ?></h1>
        <div class="card-tools">

            <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
            <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                    'method' => 'post',
                ],
            ]) ?>


        </div>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-4">

                <?= DetailView::widget([
                    'model' => $model,
                    'attributes' => [
                        //'id',
                        //'user_id',
                        'principle_tenant_name',
                        'house_number',
                        'cell_number',
                        'billing_email_address:email',
                        'id_number',
                        [
                            'attribute' => 'agreed_rent_payable',
                            'format' => ['currency', 'Ksh'],
                        ],
                        [
                            'attribute' => 'agreed_water_rate',
                            'format' => ['currency', 'Ksh'],
                        ],
                        [
                            'attribute' => 'service_charge',
                            'format' => ['currency', 'Ksh.']
                        ],
                        'has_signed_tenancy_agreement:boolean',
                        // 'created_at:datetime',
                        // 'updated_at:datetime',
                    ],
                ]) ?>
            </div>
            <div class="col-md-8">
                <div class="card card-info">
                    <div class="card-header">
                        <div class="card-title">Tenant Invoices</div>
                    </div>
                    <div class="card-body">
                        <?php if ($invoices && is_array($invoices)): ?>
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead">
                                        <tr>
                                            <td class="text text-bold">Pay Period</td>

                                            <td class="text text-bold">Rent</td>
                                            <td class="text text-bold">Water Bill</td>
                                            <td class="text text-bold">Service Charge</td>
                                            <td class="text text-bold">Total</td>
                                            <td>Action</td>
                                        </tr>

                                        </thead>
                                        <tbody>
                                            <?php if ($invoices && is_array($invoices)):
                                                foreach ($invoices as $line):
                                                    ?>
                                                    <tr>
                                                        <td><?= $line->paymentheader->payperiod->body . ' - ' . $line->paymentheader->payperiod->payperiodstatus->name ?>
                                                        </td>

                                                        <td><?= $line->agreed_rent_payable ?></td>
                                                        <td><?= $line->water_bill ?></td>
                                                        <td><?= $line->service_charge ?></td>
                                                        <td><?= Yii::$app->formatter->asCurrency(($line->agreed_rent_payable + $line->water_bill + $line->service_charge), 'Ksh.') ?>
                                                        </td>
                                                        <td>
                                                            <?= Html::a('Report', ['report', 'invoiceid' => $line->id], ['class' => 'btn btn-sm btn-warning', 'title' => 'View a Detailed Invoice']) ?>
                                                        </td>
                                                    </tr>

                                                    <?php
                                                endforeach;
                                            endif; ?>

                                        </tbody>
                                </table>
                            </div>
                        <?php else: ?>
                            <div class="alertalert-info">You have no invoices yet.</div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>


</div>