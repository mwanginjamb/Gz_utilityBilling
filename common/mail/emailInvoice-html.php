<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\User $user */

//Yii::$app->urlManager->hostInfo = env('APP_BASE_URL', 'http://utility.com');
$verifyLink = env('APP_BASE_URL', 'http://utility.com') . '/tenant/view-invoice?invoiceid=' . $paymentLine->id;
?>
<div class="envelo" style="background-color:#ddd; padding:1rem;display:flex;flex-direction:column">


    <div style="margin:1rem 0;padding: 0.5rem;flex:1;width:100%">Payment Notification for Invoice #
        KAV-INV-<?= $paymentLine->id ?></div>


    <?= "<div style='margin:1rem 0;padding:0.5rem;flex:1;width:100%'>Dear <b>" . $paymentLine->tenant->principle_tenant_name . "</b>, \n\n <br>We are notifying you about your invoice #" . 'KAV-INV-' . $paymentLine->id .
        " for <b>" . $paymentLine->paymentheader->payperiod->body . "</b><br>" .
        "\n\n Please find the Break Down below : </div>" ?>

    <div class="invoice-container"
        style="display: flex;flex-direction: column;gap:1px;padding: 20px;font-family: Arial, sans-serif;margin-top: 1rem; width:100%">

        <div class="invoice-line" style="display: flex;justify-content: space-between;align-items: center; width:80%">
            <div class="item" style="flex:1;background-color: #007bff;color: #ffffff;padding: 12px;text-align: left;">
                Rent</div>
            <div class="cost" style="flex: 1;color: #007bff;padding:12px;text-align:right;border: 1px solid #007bff;">
                <?= Yii::$app->formatter->asCurrency($paymentLine->agreed_rent_payable, 'Ksh.') ?>
            </div>
        </div>
        <div class="invoice-line" style="display: flex;justify-content: space-between;align-items: center; width:80%">
            <div class="item" style="flex:1;background-color: #007bff;color: #ffffff;padding: 12px;text-align: left;">
                Water</div>
            <div class="cost" style="flex: 1;color: #007bff;padding:12px;text-align:right;border: 1px solid #007bff;">
                <?= Yii::$app->formatter->asCurrency($paymentLine->water_bill, 'Ksh.') ?> Units Consumed:
                <?= $paymentLine->units_used ?>
            </div>
        </div>
        <div class="invoice-line" style="display: flex;justify-content: space-between;align-items: center; width:80%">
            <div class="item" style="flex:1;background-color: #007bff;color: #ffffff;padding: 12px;text-align: left;">
                Garbage</div>
            <div class="cost" style="flex: 1;color: #007bff;padding:12px;text-align:right;border: 1px solid #007bff;">
                <?= Yii::$app->formatter->asCurrency($paymentLine->service_charge, 'Ksh.') ?>
            </div>
        </div>

        <div class="invoice-line" style="display: flex;justify-content: space-between; width:80%">
            <div class="item"
                style="flex:1;background-color: #0056b3;color: #ffffff;padding:12px;font-weight: bold;border: none;">
                Total
            </div>
            <div class="cost"
                style="flex:1;background-color: #0056b3;color: #ffffff;padding:12px;text-align:right;font-weight: bold;border: none;">
                <?= Yii::$app->formatter->asCurrency($paymentLine->agreed_rent_payable + $paymentLine->water_bill + $paymentLine->service_charge, 'Ksh.') ?>
            </div>
        </div>

    </div>
</div>


<div class="button-container" style="display: flex;justify-content: center;margin: 20px 0;">
    <?= Html::a('Verify Invoice', $verifyLink, ['style' => 'text-decoration:none;background-color: #007bff;color: #ffffff;border: none;padding: 10px 20px;font-size: 14px;font-weight: bold;cursor: pointer;border-radius: 5px;transition: background-color 0.3s;']) ?>
</div>
<footer
    style="margin:1.5rem 0;padding: 10px;text-align: center;font-size: 12px;color: #666666;border-top: 1px solid #dddddd; background-color:#5a5757;">
    <p style="margin: 0;line-height: 1.5;">&copy; <?= date('Y') ?> <?= env('DEVELOPER') ?> &copy; <?= date('Y') ?> All
        rights reserved.</p>
</footer>