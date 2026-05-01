<?php

use common\models\Payperiodstatus;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\Pjax;
/** @var yii\web\View $this */
/** @var common\models\PayperiodstatusSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = Yii::t('app', 'Payperiodstatuses');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="payperiodstatus-index card card-info">
    <div class="card-header">
        <div class="card-title">
            <h1><?= Html::encode($this->title) ?></h1>
        </div>
        <div class="card-tools">
            <?= Html::a(Yii::t('app', '+ Payperiodstatus'), ['create'], ['class' => 'btn btn-outline-warning']) ?>
        </div>
    </div>
    <div class="card-body">

        <?php Pjax::begin(); ?>
        <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],

                //'id',
                'name',
                'created_at:datetime',
                'update_at:datetime',
                //'created_by',
                //'updated_by',
                [
                    'class' => ActionColumn::className(),
                    'urlCreator' => function ($action, Payperiodstatus $model, $key, $index, $column) {
                                return Url::toRoute([$action, 'id' => $model->id]);
                            }
                ],
            ],
        ]); ?>

        <?php Pjax::end(); ?>
    </div>




</div>