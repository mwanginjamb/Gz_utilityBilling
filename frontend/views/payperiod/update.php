<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\Payperiod $model */

$this->title = Yii::t('app', 'Update Billing Voucher: {name}', [
    'name' => $model->id . ' - ' . $model->body . ' for ' . $model->property->name,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Payperiods'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class=" card payperiod-update  card-info">
    <div class="card-header">

        <h3 class="card-title"><?= Html::encode($this->title) ?></h3>

    </div>
    <div class="row">
        <div class="col-md-12 px-3 my-3">
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
                <?= (($paymentheader && is_array($paymentheader['paymentlines'])) && !$model->isNewRecord && $model->payperiodstatus->name == 'Open') ? Html::a(Yii::t('app', '<i class="fas fa-redo mx-1"></i>Regenerate Pay period'), ['regenerate'], [
                    'class' => 'btn btn-dark',
                    'data' => [
                        'confirm' => Yii::t('app', 'Are you sure you want to regenerate this pay period ?'),
                        'params' => [
                            'id' => $model->id,
                            'payperiod' => $model->id,
                            'property' => $model->property_id,
                            'paymentheaderID' => $paymentheader['id'],
                        ],
                        'method' => 'post',
                    ],
                ]) : '' ?>
                <?= (!$model->isNewRecord && (!$paymentheader || !array_key_exists('paymentlines', $paymentheader))) ? Html::a(Yii::t('app', 'Generate Payment Header'), ['generate-header'], [
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
    <div class="card-body">

        <?= $this->render('_form', [
            'model' => $model,
            'properties' => $properties,
            'payperiodstatus' => $payperiodstatus,
            'paymentheader' => $paymentheader
        ]) ?>
    </div>

</div>