<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\User $user */

Yii::$app->urlManager->hostInfo = env('APP_BASE_URL', 'http://utility.com');
$verifyLink = Yii::$app->urlManager->createAbsoluteUrl(['tenant/view-invoice', 'invoiceid' => $paymentLine->id]);
?>
<div class="verify-email" style="background-color:#ddd; padding: 1rem; display: flex;flex-direction:column">
    <p>Payment Notification for Invoice # KAV-INV-<?= $paymentLine->id ?></p>
    <?php echo "<p>Dear " . $paymentLine->tenant->principle_tenant_name . ", \n\nWe are notifying you about your invoice #" . 'KAV-INV-' . $paymentLine->id .
        " with a rent amount of " . Yii::$app->formatter->asCurrency($paymentLine->agreed_rent_payable + $paymentLine->water_bill + $paymentLine->service_charge, 'Ksh.') .
        "\n\n Break Down: </p>" ?>

    <div class="invoice-container">
        <div class="invoice-line">
            <div class="item">Rent</div>
            <div class="cost"><?= Yii::$app->formatter->asCurrency($paymentLine->agreed_rent_payable, 'Ksh.') ?></div>
        </div>
        <div class="invoice-line">
            <div class="item">Water</div>
            <div class="cost"><?= Yii::$app->formatter->asCurrency($paymentLine->water_bill, 'Ksh.') ?> Units Consumed:
                <?= $paymentLine->units_used ?>
            </div>
        </div>
        <div class="invoice-line">
            <div class="item">Garbage</div>
            <div class="cost"><?= Yii::$app->formatter->asCurrency($paymentLine->service_charge, 'Ksh.') ?></div>
        </div>

        <div class="invoice-line">
            <div class="item">Total</div>
            <div class="cost">
                <?= Yii::$app->formatter->asCurrency($paymentLine->agreed_rent_payable + $paymentLine->water_bill + $paymentLine->service_charge, 'Ksh.') ?>
            </div>
        </div>

    </div>
</div>

<p>You can also verify the invoice via link below :</p>
<div class="button-container">
    <?= Html::a('Verify Invoice', $verifyLink, ['class' => 'btn']) ?></p>
</div>
<footer>
    <p>&copy; <?= date('Y') ?> <?= env('DEVELOPER') ?> &copy; <?= date('Y') ?> All rights reserved.</p>
</footer>