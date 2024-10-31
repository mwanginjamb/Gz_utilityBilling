<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\Payperiod $model */

$this->title = Yii::t('app', 'Create Payperiod');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Payperiods'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="payperiod-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'properties' => $properties
    ]) ?>

</div>