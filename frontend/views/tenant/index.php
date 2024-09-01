<?php

use common\models\Tenant;
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

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Create Tenant'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'user_id',
            'principle_tenant_name',
            'house_number',
            'cell_number',
            //'billing_email_address:email',
            //'id_number',
            //'agreed_rent_payable',
            //'agreed_water_rate',
            //'has_signed_tenancy_agreement',
            //'created_at',
            //'update_at',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, Tenant $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 }
            ],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>
