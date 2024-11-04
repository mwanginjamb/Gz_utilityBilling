<?php

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

            </div>
            <div class="col-md-8">
                <div class="card card-info">
                    <div class="card-header">
                        <div class="card-title">Current Tenants</div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">

                            <table class="table table-bordered" id="tenants">
                                <thead>
                                    <tr>
                                        <td class="text-bold">Unit</td>
                                        <td class="text-bold">Principal Member</td>
                                        <td class="text-bold">Rent Payable</td>
                                        <td class="text-bold">Water Cost Per Unit </td>
                                        <td class="text-bold">Cell Number</td>
                                        <td class="text-bold">Billing Address</td>

                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    // Yii::$app->utility->printrr($occupiedUnits);
                                    if ($occupiedUnits && count($occupiedUnits)):
                                        foreach ($occupiedUnits as $ou):
                                            $unit = (object) $ou;
                                            ?>
                                            <tr>
                                                <td><?= $unit->unit_name ?></td>
                                                <td><?= $unit->tenant['principle_tenant_name'] ?></td>
                                                <td><?= Yii::$app->formatter->asCurrency($unit->tenant['agreed_rent_payable'], 'Ksh.') ?>
                                                </td>
                                                <td><?= Yii::$app->formatter->asCurrency($unit->tenant['agreed_water_rate'], 'Ksh.') ?>
                                                </td>
                                                <td><?= $unit->tenant['cell_number'] ?></td>
                                                <td><?= $unit->tenant['billing_email_address'] ?></td>
                                            </tr>
                                        <?php endforeach;
                                    endif;
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
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