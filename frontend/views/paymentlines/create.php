<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\Paymentlines $model */

$this->title = Yii::t('app', 'Create Paymentlines');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Paymentlines'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="paymentlines-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
