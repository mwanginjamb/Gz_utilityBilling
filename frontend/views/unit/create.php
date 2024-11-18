<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\Unit $model */

$this->title = Yii::t('app', 'Create Unit for Estate No: ' . Yii::$app->request->get('property'));
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Units'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="unit-create card card-info">
    <div class="card-header">

        <div class="card-title">
            <h3><?= Html::encode($this->title) ?></h3>
        </div>
        <div class="card-tools">
            <?= Html::a(Yii::t('app', '<i class="fas fa-file-excel"></i> Import Units'), ['excel-import', 'property' => $model->property_id], ['class' => 'btn btn-success']) ?>
            <?= Html::a(Yii::t('app', '<i class="fas fa-download"></i> Download Template'), ['download', 'templateName' => 'estate_entity_import_template.xlsx'], ['class' => 'btn btn-warning']) ?>
        </div>

    </div>
    <div class="card-body">

        <?= $this->render('_form', [
            'model' => $model,
        ]) ?>
    </div>


</div>