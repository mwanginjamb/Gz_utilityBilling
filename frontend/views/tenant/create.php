<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\Tenant $model */

$this->title = Yii::t('app', 'Create Tenant');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Tenants'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tenant-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
