<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\User $user */

//Yii::$app->urlManager->hostInfo = env('APP_BASE_URL', 'http://utility.com');
$verifyLink = env('APP_BASE_URL', 'http://utility.com') . '/tenant/view-invoice?invoiceid=' . $paymentLine->id;
?>

<div class="envelo" style="background-color:#ddd; padding:1rem; width: 100%; max-width: 600px;">

    <table style="width: 100%; margin: 1rem 0; padding: 0.5rem;">
        <tr>
            <td>Payment Notification for Invoice # KAV-INV-<?= $paymentLine->id ?></td>
        </tr>
    </table>

    <table style="width: 100%; margin: 1rem 0; padding: 0.5rem;">
        <tr>
            <td>Dear <b><?= $paymentLine->tenant->principle_tenant_name ?></b>, <br><br>
                We are notifying you about your invoice # KAV-INV-<?= $paymentLine->id ?> for
                <b><?= $paymentLine->paymentheader->payperiod->body ?></b><br>
                <br>Please find the Break Down below:
            </td>
        </tr>
    </table>

    <table style="width: 100%; padding: 20px; font-family: Arial, sans-serif;">
        <tr>
            <td class="item"
                style="background-color: #007bff; color: #ffffff; padding: 12px; text-align: left; width: 50%;">Rent
            </td>
            <td class="cost"
                style="color:#007bff; padding: 11px; text-align: right; border: 1px solid #007bff; width: 50%;">
                <?= Yii::$app->formatter->asCurrency($paymentLine->agreed_rent_payable, 'Ksh.') ?>
            </td>
        </tr>
        <tr>
            <td class="item" style="background-color: #007bff; color: #ffffff; padding: 12px; text-align: left;">Water
            </td>
            <td class="cost" style="color: #007bff; padding: 11px; text-align: right; border: 1px solid #007bff;">
                <?= Yii::$app->formatter->asCurrency($paymentLine->water_bill, 'Ksh.') ?> Units Consumed:
                <?= $paymentLine->units_used ?>
            </td>
        </tr>
        <tr>
            <td class="item" style="background-color: #007bff; color: #ffffff; padding: 12px; text-align: left;">Garbage
            </td>
            <td class="cost" style="color: #007bff; padding: 11px; text-align: right; border: 1px solid #007bff;">
                <?= Yii::$app->formatter->asCurrency($paymentLine->service_charge, 'Ksh.') ?>
            </td>
        </tr>
        <tr>
            <td class="item"
                style="background-color: #0056b3; color: #ffffff; padding: 12px; font-weight: bold; text-align: left;">
                Total</td>
            <td class="cost"
                style="background-color: #0056b3; color: #ffffff; padding: 11px; text-align: right; font-weight: bold;">
                <?= Yii::$app->formatter->asCurrency($paymentLine->agreed_rent_payable + $paymentLine->water_bill + $paymentLine->service_charge, 'Ksh.') ?>
            </td>
        </tr>
    </table>
</div>



<div class="button-container" style="display: flex;justify-content: center;margin: 20px 0;">
    <?= Html::a('Verify Invoice', $verifyLink, ['style' => 'text-decoration:none;background-color: #007bff;color: #ffffff;border: none;padding: 10px 20px;font-size: 14px;font-weight: bold;cursor: pointer;border-radius: 5px;transition: background-color 0.3s;']) ?>
</div>
<footer style="margin:1.5rem 0;text-align: center;font-size: 12px;color: #ffffff;border-top: 1px solid #dddddd; ">
    <p style="padding: 10px;background-color:#5a5757;margin: 0;line-height: 1.5;">&copy; <?= date('Y') ?>
        <?= env('DEVELOPER') ?> &copy; <?= date('Y') ?> All
        rights reserved.
    </p>
</footer>