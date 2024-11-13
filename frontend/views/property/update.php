<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\Property $model */

$this->title = Yii::t('app', 'Update Property: {name}', [
    'name' => $model->name,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Properties'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="property-update card card-info">
    <div class="card-header">
        <div class="card-title">
            <h3 class="card-title"><?= Html::encode($this->title) ?></h3>
        </div>
        <div class="card-tools">
            <?= Html::a(Yii::t('app', '<i class="fas fa-plus"></i>Add Unit'), ['unit/create'], [
                'class' => 'btn btn-warning',
                'data' => [
                    'params' => [
                        'property' => $model->id
                    ],
                    'method' => 'GET',
                ],
            ]) ?>
        </div>
    </div>
    <div class="card-body">
        <?= $this->render('_form', [
            'model' => $model,
        ]) ?>
    </div>

</div>