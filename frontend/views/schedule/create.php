<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\Schedule $model */

$this->title = Yii::t('app', 'Create Schedule');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Schedules'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="schedule-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
