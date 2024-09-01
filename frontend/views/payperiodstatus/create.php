<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\Payperiodstatus $model */

$this->title = Yii::t('app', 'Create Payperiodstatus');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Payperiodstatuses'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="payperiodstatus-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
