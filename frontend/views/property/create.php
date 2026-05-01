<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\Property $model */

$this->title = Yii::t('app', 'Create Property');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Properties'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="property-create card card-info">
    <div class="card-header">
        <h1 class="card-title"><?= Html::encode($this->title) ?></h1>
    </div>
    <div class="card-body">
        <?= $this->render('_form', [
            'model' => $model,
        ]) ?>
    </div>

</div>