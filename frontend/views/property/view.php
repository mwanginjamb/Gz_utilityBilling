<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */




/** @var common\models\Property $model */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Properties'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="card property-view">
    <div class="card-header">
        <div class="card-title">
            <h1><?= Html::encode($this->title) ?></h1>
        </div>
        <div class="card-tools">

            <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
            <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                    'method' => 'post',
                ],
            ]) ?>
            <?= Html::a(Yii::t('app', 'Pay Periods'), ['payperiod/property-payperiods'], [
                'class' => 'btn btn-info',
                'data' => [
                    'params' => [
                        'id' => $model->id
                    ],
                    'method' => 'post',
                ],
            ]) ?>


        </div>
    </div>
    <div class="card-body">
        <?= $this->render('_stats', [
            'totalTenants' => $totalTenants,
            'totalVacant' => $totalVacant,
            'totalRevenue' => $totalRevenue,

        ]) ?>
        <div class="div row">
            <div class="col-md-4">
                <?= DetailView::widget([
                    'model' => $model,
                    'attributes' => [
                        //'id',
                        'name',
                        'build_date',
                        'created_at:datetime',
                        // 'updated_at',
                        // 'created_by',
                        // 'updated_by',
                    ],
                ]) ?>

                <?php if ($model->billing_type !== 'composite'): ?>
                    <div class="card card-info">
                        <div class="card-header">
                            <div class="card-title">
                                <div class="text">Automate Billing (Add a billing interval)</div>
                            </div>
                            <div class="card-tools">
                                <?= Html::a('<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-repeat" viewBox="0 0 16 16">
                <path d="M11.534 7h3.932a.25.25 0 0 1 .192.41l-1.966 2.36a.25.25 0 0 1-.384 0l-1.966-2.36a.25.25 0 0 1 .192-.41m-11 2h3.932a.25.25 0 0 0 .192-.41L2.692 6.23a.25.25 0 0 0-.384 0L.342 8.59A.25.25 0 0 0 .534 9"/>
                <path fill-rule="evenodd" d="M8 3c-1.552 0-2.94.707-3.857 1.818a.5.5 0 1 1-.771-.636A6.002 6.002 0 0 1 13.917 7H12.9A5 5 0 0 0 8 3M3.1 9a5.002 5.002 0 0 0 8.757 2.182.5.5 0 1 1 .771.636A6.002 6.002 0 0 1 2.083 9z"/>
                </svg>', ['schedule'], [
                                    'class' => 'btn btn-sm btn-warning',
                                    'data' => [
                                        'params' => [
                                            'property' => $model->id
                                        ],
                                        'method' => 'POST'
                                    ]
                                ]) ?>
                            </div>
                        </div>
                        <div class="card-title">
                            <?php if ($schedule):
                                $endpoint = Url::home(true) . 'apiv1/schedules/' . $schedule->id ?>
                                <table class="table table-boardered">
                                    <theader>
                                        <tr>
                                            <td class="text text-bold text-center text-info">Billing Date</td>
                                        </tr>
                                    </theader>
                                    <tbody>
                                        <tr>
                                            <td data-key="<?= $schedule->id ?>" data-name="billing_date"
                                                class="billing_date text-info text text-center" data-service="<?= $endpoint ?>"
                                                ondblclick="addInput(this,'date')">
                                                <?= Yii::$app->formatter->asDate($schedule->billing_date) ?>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            <?php else: ?>
                                <div class="alert my-3">Automated Billing is not enabled.</div>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endif; ?>
                <!-- Vacant Units -->

                <?php if ($vacantUnits && is_array($vacantUnits) && count($vacantUnits)): ?>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <theader>
                                <tr class="bg-info">
                                    <th>Vacant Units</th>
                                </tr>
                            </theader>
                            <tbody>
                                <?php foreach ($vacantUnits as $unit): ?>
                                    <tr>
                                        <td><?= $unit['unit_name'] ?? 'not set' ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>

                <?php endif; ?>


            </div>
            <div class="col-md-8">
                <?= $this->render('_tenants', [
                    'model' => $model,
                    'occupiedUnits' => $occupiedUnits
                ]) ?>
            </div>
        </div>

    </div>



</div>

<?php
$script = <<<JS
$(function(){  
    $('#tenants').DataTable();
});
JS;

$this->registerJs($script);