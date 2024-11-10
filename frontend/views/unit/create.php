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
        <h1 class="card-title"><?= Html::encode($this->title) ?></h1>

    </div>
    <div class="card-body">

        <?= $this->render('_form', [
            'model' => $model,
        ]) ?>
    </div>


</div>