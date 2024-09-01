<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\Paymentheader $model */

$this->title = Yii::t('app', 'Create Paymentheader');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Paymentheaders'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="paymentheader-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
