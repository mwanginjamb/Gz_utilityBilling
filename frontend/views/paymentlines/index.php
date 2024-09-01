<?php

use common\models\Paymentlines;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\Pjax;
/** @var yii\web\View $this */
/** @var common\models\PaymentlinesSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = Yii::t('app', 'Paymentlines');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="paymentlines-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Create Paymentlines'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'paymentheader_id',
            'opening_water_readings',
            'closing_water_readings',
            'settled',
            //'created_at',
            //'update_at',
            //'created_by',
            //'updated_by',
            //'deleted',
            //'deleted_at',
            //'deleted_by',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, Paymentlines $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 }
            ],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>
