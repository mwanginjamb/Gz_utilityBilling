<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var common\models\Payperiod $model */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Payperiods'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="card payperiod-view">

    <div class="card-header">
        <h1 class="card-title"><?= Html::encode($model->body . ' for Property: ' . $model->property->name) ?></h1>
    </div>
    <div class="card-body">
        <?php if ($model->payperiodstatus->name == 'Open'): ?>
            <div
                class="actions my-2 d-flex py-2 px-2 justify-content-between align-items-center border border-1 border-info rounded-1">
                <div class="payperiod-actions">

                    <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
                    <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
                        'class' => 'btn btn-danger',
                        'data' => [
                            'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                            'method' => 'post',
                        ],
                    ]) ?>


                </div>

                <div class="paymentheader-actions">
                    <?= Html::a(Yii::t('app', 'Close Pay period'), ['close'], [
                        'class' => 'btn btn-warning',
                        'data' => [
                            'confirm' => Yii::t('app', 'Are you sure you want to close this pay period ?'),
                            'params' => [
                                'id' => $model->id
                            ],
                            'method' => 'post',
                        ],
                    ]) ?>
                    <?= Html::a(Yii::t('app', 'Generate Payment Header'), ['generate-header'], [
                        'class' => 'btn btn-info',
                        'data' => [
                            'confirm' => Yii::t('app', 'Are you sure you want to generate payment header for this pay period?'),
                            'params' => [
                                'payperiod' => $model->id,
                                'property' => $model->property_id
                            ],
                            'method' => 'post',
                        ],
                    ]) ?>
                    <?= Html::a(Yii::t('app', 'Invoice Tenants'), ['invoice'], [
                        'class' => 'btn btn-success',
                        'data' => [
                            'confirm' => Yii::t('app', 'Are you sure you want to Invoice tenants in this property for this pay period ?'),
                            'params' => [
                                'id' => $model->id
                            ],
                            'method' => 'post',
                        ],
                    ]) ?>

                </div>
            </div>
        <?php endif; ?>
        <div class="row">
            <div class="col-md-4">

                <?= DetailView::widget([
                    'model' => $model,
                    'attributes' => [
                        //'id',
                        'period',
                        'body:ntext',
                        [
                            'attribute' => 'property_id',
                            'value' => function ($model) {
                            return $model->property->name;
                        }
                        ],
                        [
                            'attribute' => 'payperiodstatus_id',
                            'value' => function ($model) {
                            return $model->payperiodstatus->name;
                        }
                        ],
                        'created_at:datetime',
                        // 'update_at',
                        // 'created_by',
                        // 'updated_by',
                    ],
                ]) ?>
            </div>
            <div class="col-md-8">



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
                                ?>
                                <tr class="<?= $class ?>">

                                    <td><?= $line->tenant_name ?></td>
                                    <td><?= Yii::$app->formatter->asCurrency($line->agreed_rent_payable, 'Ksh.') ?></td>
                                    <td><?= $line->agreed_water_rate ?></td>
                                    <td><?= $line->opening_water_readings ?></td>
                                    <td data-key="<?= $line->id ?>" data-name="closing_water_readings"
                                        data-service="http://localhost:88/apiv1/paymentlines"
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

    </div>

</div>

<?php

$script = <<<JS

$(function(){
        
    $('#paymentlines').DataTable();
});
JS;

$this->registerJs($script);