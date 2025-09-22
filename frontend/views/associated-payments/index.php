<?php
use yii\helpers\Html;
use yii\helpers\Url;

/** @var yii\web\View $this */
/** @var common\models\AssociatedPaymentsSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = Yii::t('app', 'Associated Payments for : ') . ucwords($invoice->paymentheader->payperiod->body);
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="associated-payments-index card card-info">
    <div class="card-header">
        <h1 class="card-title"><?= Html::encode($this->title) ?></h1>

    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>#</th>
                        <th><?= Yii::t('app', 'Payment Line ID'); ?></th>
                        <th class="text-info"><?= Yii::t('app', 'Payment Description'); ?></th>
                        <th class="text-info"><?= Yii::t('app', 'Payment Amount'); ?></th>
                        <th><?= Yii::t('app', 'Created At'); ?></th>
                        <th><?= Html::a('Add Payment', Url::home(true) . 'apiv1/associatedpayments', [
                            'class' => 'btn btn-sm btn-dark add',
                            'title' => 'Add an Associated Payment',
                            'data-paymentline_id' => Yii::$app->request->get('invoiceid'),
                            'data-endpoint' => Url::home(true) . 'apiv1/associatedpayments',
                            'data-template' => 1,
                            //'data-reload' => 1
                        ]) ?></th>
                    </tr>
                </thead>
                <tbody>
                    <!--  template -->
                    <tr class="templateRow parent" style="display: none">
                        <td><?= count($dataProvider->getModels()) + 1 ?></td>
                        <td data-name="paymentline_id"><?= Yii::$app->request->get('invoiceid') ?></td>
                        <td data-name="payment_description"></td>
                        <td data-name="payment_amount">0</td>
                        <td data-name="created_at">0</td>
                        <td>
                            <?= Html::a('<i class="fas fa-trash"></i>', '#', ['class' => 'btn btn-danger btn-sm delete']) ?>
                        </td>
                    </tr>
                    <?php foreach ($dataProvider->getModels() as $index => $model):
                        $endpoint = Url::home(true) . 'apiv1/associatedpayments/' . $model->id;
                        ?>
                        <tr>
                            <td><?= $index + 1; ?></td>
                            <td><?= Html::encode($model->paymentline_id); ?></td>
                            <td data-key="<?= $model->id ?>" data-name="sub_clause" data-service="<?= $endpoint ?>"
                                ondblclick="addInput(this)"></td><?= Html::encode($model->payment_description); ?></td>
                            <td data-key="<?= $model->id ?>" data-name="sub_clause" data-service="<?= $endpoint ?>"
                                ondblclick="addInput(this)"></td><?= Html::encode($model->payment_amount); ?></td>
                            <td><?= Html::encode(Yii::$app->formatter->asDatetime($model->created_at)); ?></td>
                            <td>
                                <?= Html::a('<i class="fas fa-trash"></i>', $endpoint, [
                                    'class' => 'btn btn-danger btn-sm delete',
                                    'data-service' => $endpoint,
                                    'data-key' => $model->id
                                ]) ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>


</div>