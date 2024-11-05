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
<div class="card card-info">

    <div class="card-header">
        <h2 class="card-title">Property Payperiods</h2>
    </div>
    <div class="card-body">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <td class="text-info text-bold">Period</td>
                    <td class="text-info text-bold">Description</td>
                    <td class="text-info text-bold">Status</td>
                    <td class="text-info text-bold">Details</td>
                </tr>
            </thead>
            <tbody>
                <?php
                if (is_array($items) && count($items)):
                    foreach ($items as $item): ?>
                        <tr>
                            <td><?= $item->period ?></td>
                            <td><?= $item->body ?></td>
                            <td><?= $item->payperiodstatus->name ?></td>
                            <td>
                                <?= Html::a('Update', ['update', 'id' => $item['id']], ['_target' => '_blank', 'class' => 'btn btn-warning']) ?>
                                <?= Html::a('view', ['view', 'id' => $item['id']], ['target' => '_blank', , 'class' => 'btn btn-info']) ?>
                            </td>
                        </tr>
                    <?php endforeach;
                endif;
                ?>
            </tbody>
        </table>
    </div>

</div>