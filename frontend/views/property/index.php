<?php

use common\models\Property;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\Pjax;
/** @var yii\web\View $this */
/** @var common\models\PropertySearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = Yii::t('app', 'Properties');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="property-index card card-info">
    <div class="card-header">
        <div class="card-title">
            <h3><?= Html::encode($this->title) ?></h3>
        </div>
        <div class="card-tools">
            <?= Html::a(Yii::t('app', '+ Create Property'), ['create'], ['class' => 'btn btn-outline-warning']) ?>

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
                'build_date',
                'created_at',
                'updated_at',
                //'created_by',
                //'updated_by',
                [
                    'class' => ActionColumn::className(),
                    'urlCreator' => function ($action, Property $model, $key, $index, $column) {
                                return Url::toRoute([$action, 'id' => $model->id]);
                            }
                ],
            ],
        ]); ?>

        <?php Pjax::end(); ?>
    </div>



</div>