<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\Payperiod $model */

$this->title = Yii::t('app', 'Update Payperiod: {name}', [
    'name' => $model->id . ' - ' . $model->body . ' for ' . $model->property->name,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Payperiods'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class=" card payperiod-update">
    <div class="card-header">

        <h1 class="card-title"><?= Html::encode($this->title) ?></h1>
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