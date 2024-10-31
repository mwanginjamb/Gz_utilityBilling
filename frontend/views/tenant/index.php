<?php

use common\models\Tenant;
use yii\bootstrap5\LinkPager;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\Pjax;
/** @var yii\web\View $this */
/** @var common\models\TenantSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = Yii::t('app', 'Tenants');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tenant-index">

    <div class="card card-info">
        <div class="card-header">
            <div class="card-title"><?= $this->title ?></div>
        </div>
        <div class="card-body">
            <table class="table" id="table">
                <thead>
                    <tr>
                        <td class="text text-bold text-info">Principal Tenant</td>
                        <td class="text text-bold text-info">Unit</td>
                        <td class="text text-bold text-info">Property</td>
                        <td class="text text-bold text-info">billing address</td>
                        <td class="text text-bold text-info">Agreed Rent Payable</td>
                        <td class="text text-bold text-info">Water Utility Bill / Unit</td>
                        <td class="text text-bold text-info">Signed Tenancy Agreement?</td>
                        <td class="text text-bold text-info">Actions</td>

                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($dataProvider as $model): ?>
                        <tr>
                            <td><?= $model->principle_tenant_name ?></td>
                            <td><?= $model->unit->unit_name ?></td>
                            <td><?= $model->unit->property->name ?></td>
                            <td><?= $model->billing_email_address ?></td>
                            <td><?= Yii::$app->formatter->asCurrency($model->agreed_rent_payable, 'Ksh') ?></td>
                            <td><?= Yii::$app->formatter->asCurrency($model->agreed_water_rate, 'Ksh') ?></td>
                            <td><?= Yii::$app->formatter->asBoolean($model->has_signed_tenancy_agreement) ?></td>
                            <td>
                                <?= $Viewlink = Html::a('<i class="fas fa-eye"></i> View', ['view'], [
                                    'class' => 'btn btn-outline-primary btn-xs mx-1',
                                    'title' => 'View Document',
                                    'data' => [
                                        'params' => [
                                            'id' => $model->id
                                        ],
                                        'method' => 'GET'
                                    ]

                                ]); ?>
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
        var groupColumn = 2;
            var table_budget = $('#table').DataTable({
                columnDefs: [{ visible: false, targets: groupColumn }],
                order: [[groupColumn, 'desc']],
                displayLength: 25,
                drawCallback: function (settings) {
                    var api = this.api();
                    var rows = api.rows({ page: 'current' }).nodes();
                    var last = null;
            
                    api.column(groupColumn, { page: 'current' })
                        .data()
                        .each(function (group, i) {
                            if (last !== group) {
                                $(rows)
                                    .eq(i)
                                    .before(
                                        '<tr class="group text text-bold text-center"><td colspan="6">' +
                                            group +
                                            '</td></tr>'
                                    );
            
                                last = group;
                            }
                        });
                }
            });
});
JS;

$this->registerJs($script);