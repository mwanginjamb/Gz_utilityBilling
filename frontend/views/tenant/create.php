<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\Tenant $model */

$this->title = Yii::t('app', 'Create Tenant');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Tenants'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tenant-create card">

    <div class="card-header">
        <div class="card-title">
            <h3><?= Html::encode($this->title) ?></h3>
        </div>
    </div>
    <div class="card-body">
        <?= $this->render('_form', [
            'model' => $model,
            'units' => $units
        ]) ?>
    </div>

</div>