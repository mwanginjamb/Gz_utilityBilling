<?php

use yii\helpers\Url;
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
                <div class="row">
                    <div class="col-md-6">
                        <div class="card card-info">
                            <div class="card-header">
                                <div class="card-title">
                                    <div class="text">Asset Affiliation</div>
                                </div>
                                <div class="card-tools">
                                    <?= Html::a('+ <i class="ion-ios-briefcase"></i>', ['asset'], [
                                        'class' => 'btn btn-sm btn-info',
                                        'title' => 'Add an asset you own e.g a vehicle',
                                        'data' => [
                                            'params' => [
                                                'tenant' => $model->id
                                            ],
                                            'method' => 'POST'
                                        ]
                                    ]) ?>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <td class="fw-bold">Asset</td>
                                                <td class="fw-bold">Unique ID</td>
                                                <td class="fw-bold">Action</td>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($assets as $v):
                                                $endpoint = Url::home(true) . 'apiv1/assets/' . $v->id ?>
                                                <tr>
                                                    <td data-name="asset_description" class="asset_description text text-center" data-service="<?= $endpoint ?>"
                                                        ondblclick="addInput(this)">
                                                        <?= $v->asset_description ?? '' ?>
                                                    </td>
                                                    <td data-name="asset_unique_identifier" class="asset_unique_identifier text text-center" data-service="<?= $endpoint ?>"
                                                        ondblclick="addInput(this)">
                                                        <?= $v->asset_unique_identifier ?? '' ?>
                                                    </td>
                                                    <td>
                                                        <?= Html::a('<i class="bi bi-trash"></i>',$endpoint,['class' => 'btn btn-danger btn-sm delete']) ?>
                                                    </td>
                                                
                                            </tr>
                                            
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card card-info">
                            <div class="card-header">
                                <div class="card-title">
                                    <div class="text">Visitor Records</div>
                                </div>
                                <div class="card-tools">
                                    <?= Html::a('+ <i class="ion-ios-people"></i>', ['visitor'], [
                                        'class' => 'btn btn-sm btn-info',
                                        'title' => 'Add visitor',
                                        'data' => [
                                            'params' => [
                                                'tenant' => $model->id
                                            ],
                                            'method' => 'POST'
                                        ]
                                    ]) ?>
                                </div>
                            </div>
                            <div class="card-body">
                            <?php if ($visitors): ?>
                                <div class="table-responsive">
                                    <table class="table table-boardered">
                                        <theader>
                                            <tr>
                                                <td class="text text-bold text-center text-info">Name</td>
                                                <td class="text text-bold text-center text-info">Cell No.</td>
                                                <td class="text text-bold text-center text-info">Email</td>
                                            </tr>
                                        </theader>
                                        <tbody>

                                         <?php foreach ($visitors as $v):
                                             $endpoint = Url::home(true) . 'apiv1/visitors/' . $v->id ?>
                                            <tr>
                                                <td data-name="fullnames"
                                                    class="fullnames text text-center" data-service="<?= $endpoint ?>"
                                                    ondblclick="addInput(this)">
                                                    <?= $v->fullnames?? 'Dbl click to  type ...' ?>
                                                </td>
                                                <td data-name="cell_number"
                                                    class="cell_number text text-center" data-service="<?= $endpoint ?>"
                                                    ondblclick="addInput(this)">
                                                    <?= $v->cell_number??'' ?>
                                                </td>
                                                <td data-name="email_address"
                                                    class="email_address text text-center" data-service="<?= $endpoint ?>"
                                                    ondblclick="addInput(this)">
                                                    <?= $v->email_address?? '' ?>
                                                </td>
                                            </tr>

                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                                <?php else: ?>
                                    <div class="alert my-3">No visitors recorded yet.</div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
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
                                            <!-- <td class="text text-bold">Rent</td> -->
                                            <!-- <td class="text text-bold">Water Bill</td> -->
                                            <!-- <td class="text text-bold">Service Charge</td> -->
                                            <td class="text text-bold">Total</td>
                                            <td class="text text-bold">View Invoice</td>
                                            <td class="text text-bold">Download Invoice</td>
                                        </tr>

                                        </thead>
                                        <tbody>
                                            <?php if ($invoices && is_array($invoices)):
                                                foreach ($invoices as $line):
                                                    ?>
                                                    <tr>
                                                        <td><?= $line->paymentheader->payperiod->body . ' - ' . $line->paymentheader->payperiod->payperiodstatus->name ?>
                                                        </td>
                                                        <!-- <td><?= $line->agreed_rent_payable ?></td>
                                                        <td><?= $line->water_bill ?></td>
                                                        <td><?= $line->service_charge ?></td> -->
                                                        <td><?= Yii::$app->formatter->asCurrency(($line->agreed_rent_payable + $line->water_bill + $line->service_charge), 'Ksh.') ?>
                                                        </td>
                                                        <td>
                                                            <?= Html::a('view Invoice', ['view-invoice', 'invoiceid' => $line->id], ['class' => 'btn btn-sm btn-warning', 'title' => 'View a Detailed Invoice', 'target' => '_blank']) ?>
                                                        </td>
                                                        <td>
                                                            <?= Html::a('Download Invoice', ['report', 'invoiceid' => $line->id], ['class' => 'btn btn-sm btn-warning', 'title' => 'View a Detailed Invoice', 'target' => '_blank']) ?>
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