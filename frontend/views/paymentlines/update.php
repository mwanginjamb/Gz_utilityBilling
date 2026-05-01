<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\Paymentlines $model */

$this->title = Yii::t('app', '{name}', [
    'name' => 'Payment Line - ' . $model->id . ' for Tenant: ' . $tenant,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Paymentlines'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class=" card card-info paymentlines-update">
    <div class="card-header">
        <h1 class="card-title"><?= Html::encode($this->title) ?></h1>
    </div>
    <div class="card-body">

        <?= $this->render('_form', [
            'model' => $model,
            'tenant' => $tenant
        ]) ?>
    </div>

</div>