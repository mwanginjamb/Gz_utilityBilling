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
        <div class="card-title">
            <h3>Property Payperiods</h3>
        </div>
        <div class="card-tools">
            <?= Html::a(Yii::t('app', '+ Payperiod'), ['create'], ['class' => 'btn btn-warning', 'title' => 'Add a new record.']) ?>
        </div>
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
                                <?= ($item->payperiodstatus_id == Payperiod::STATUS_OPEN) ? Html::a('Update', ['update', 'id' => $item->id], ['_target' => '_blank', 'class' => 'btn btn-warning']) : '' ?>
                                <?= ($item->payperiodstatus_id == Payperiod::STATUS_CLOSED) ? Html::a('<i class="fas fa-redo mx-1"></i>Reopen', ['reopen'], [
                                    'class' => 'btn btn-success',
                                    'data' => [
                                        'confirm' => Yii::t('app', 'Are you sure you want to reopen this pay period ?'),
                                        'params' => [
                                            'id' => $item->id
                                        ],
                                        'method' => 'post',
                                    ]
                                ]) : '' ?>
                                <?= Html::a('view', ['view', 'id' => $item->id], ['target' => '_blank', 'class' => 'btn btn-info']) ?>
                            </td>
                        </tr>
                    <?php endforeach;
                endif;
                ?>
            </tbody>
        </table>
    </div>

</div>