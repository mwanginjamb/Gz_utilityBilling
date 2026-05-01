<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\AssociatedPayments $model */

$this->title = Yii::t('app', 'Create Associated Payments');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Associated Payments'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="associated-payments-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
