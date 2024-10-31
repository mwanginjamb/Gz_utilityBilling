<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var common\models\Payperiod $model */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Payperiods'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="payperiod-view">

    <h1><?= Html::encode($this->title) ?></h1>
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

        </div>
    </div>
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

                <div class="px-3 py-2 w-100 d-flex flex-column">
                    <div class="div">
                        Property Id: <?= $paymentheader['property_id'] ?>
                    </div>
                </div>


                <table class="table table-bordered" id="paymentlines">
                    <thead>
                        <tr>
                            <td class="info text-bold">Header ID</td>
                            <td class="info text-bold">Tenant Name</td>
                            <td class="info text-bold">Rent</td>
                            <td class="info text-bold">Water Rate/Unit</td>
                            <td class="info text-bold">Opening Water Reading</td>
                            <td class="info text-info text-bold">Closing Water Reading</td>
                            <td class="info text-bold">Water Bill</td>
                            <td>Action</td>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($paymentheader['paymentlines'] as $line):
                            $line = (object) $line ?>
                            <tr>
                                <td><?= $line->paymentheader_id ?></td>
                                <td><?= $line->tenant_name ?></td>
                                <td><?= $line->agreed_rent_payable ?></td>
                                <td><?= $line->agreed_water_rate ?></td>
                                <td><?= $line->opening_water_readings ?></td>
                                <td><?= $line->closing_water_readings ?></td>
                                <td><?= ($line->closing_water_readings - $line->opening_water_readings) ?></td>
                                <td>
                                    <?= $Viewlink = Html::a('<i class="fas fa-eye"></i> Update', ['view'], [
                                        'class' => 'btn btn-outline-primary btn-xs mx-1',
                                        'title' => 'Update Invoice Line',
                                        'data' => [
                                            'params' => [
                                                'id' => $model->id
                                            ],
                                            'method' => 'GET'
                                        ]

                                    ]); ?>
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

<?php

$script = <<<JS

$(function(){
        
    $('#paymentlines').DataTable();
});
JS;

$this->registerJs($script);