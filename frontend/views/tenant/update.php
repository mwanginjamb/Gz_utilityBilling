<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\Tenant $model */

$this->title = Yii::t('app', 'Update Tenant: {name}', [
    'name' => $model->id,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Tenants'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="tenant-update card card-info">

    <div class="card-header">
        <h3 class="card-title"><?= Html::encode($this->title) ?></h3>
    </div>

    <div class="card-body">
        <?= $this->render('_form', [
            'model' => $model,
            'units' => $units
        ]) ?>
    </div>

</div>