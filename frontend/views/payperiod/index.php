<?php

use common\models\Payperiod;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\Pjax;
/** @var yii\web\View $this */
/** @var common\models\PayperiodSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = Yii::t('app', 'Payperiods');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="payperiod-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Create Payperiod'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            // 'id',
            'period',
            'body:ntext',
            [
                'attribute' => 'property_id',
                'label' => 'Property',
                'value' => 'property.name'
            ],
            [
                'attribute' => 'payperiodstatus_id',
                'value' => function (Payperiod $model) {
                        if ($model->payperiodstatus) {
                            return $model->payperiodstatus->name;
                        }
                        return null;
                    }
            ],
            //'created_at',
            //'update_at',
            //'created_by',
            //'updated_by',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, Payperiod $model, $key, $index, $column) {
                        return Url::toRoute([$action, 'id' => $model->id]);
                    }
            ],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>