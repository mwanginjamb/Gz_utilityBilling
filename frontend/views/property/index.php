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


        <div class="table-responsive">
            <table class="table table-bordered" id="properties">
                <thead>
                    <tr>
                        <td class="tx-bold">Property</td>
                        <td class="tx-bold">Build Date</td>
                        <td class="tx-bold">Created At</td>
                        <td class="tx-bold">Updated At</td>
                        <td class="tx-bold">Update Action</td>
                        <td class="tx-bold">View Action</td>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($dataProvider as $model): ?>
                        <tr>
                            <td><?= $model->name ?></td>
                            <td><?= Yii::$app->formatter->asDate($model->build_date) ?></td>
                            <td><?= Yii::$app->formatter->asDateTime($model->created_at) ?></td>
                            <td><?= Yii::$app->formatter->asDateTime($model->updated_at) ?></td>
                            <td><?= Html::a('<i class="fa fa-edit mx-1"></i> update', ['update', 'id' => $model->id], ['class' => 'btn btn-sm btn-warning']) ?>
                            </td>
                            <td>
                                <?= Html::a('<i class="fa fa-eye mx-1"></i> view', ['view', 'id' => $model->id], ['class' => 'btn btn-sm btn-primary']) ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>


    </div>



</div>
<?php
$script = <<<JS

$(function(){
            var table_budget = $('#properties').DataTable();
});
JS;

$this->registerJs($script);