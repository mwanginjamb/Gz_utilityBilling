<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\Unit $model */

$this->title = Yii::t('app', 'Create Unit');
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
        </div>

    </div>
    <div class="card-body">

        <?= $this->render('_form', [
            'model' => $model,
        ]) ?>
    </div>


</div>