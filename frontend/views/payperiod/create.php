<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\Payperiod $model */

$this->title = Yii::t('app', 'Create Payperiod');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Payperiods'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="payperiod-create card card-info">
    <div class="card-header">
        <div class="card-title">
            <h3><?= Html::encode($this->title) ?></h3>
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


</div>