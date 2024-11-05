<?php
namespace common\jobs;

use Yii;
use yii\base\BaseObject;
use yii\helpers\VarDumper;
use yii\queue\JobInterface;
use common\models\Paymentlines;

class SendEmailJob extends BaseObject implements JobInterface
{
    public $paymentLineId;
    public function execute($queue)
    {
        try {
            $paymentLine = Paymentlines::find()
                ->joinWith('tenant')
                ->andWhere(['paymentlines.id' => $this->paymentLineId])
                ->andWhere(['not', ['tenant.id' => NULL]])
                ->andWhere(['invoiced' => NULL])
                ->one();
            // Yii::info('PaymentLine to invoice: ' . VarDumper::dumpAsString($paymentLine), 'jobInfo');
            // Yii::info('Tenant  to invoice: ' . VarDumper::dumpAsString($paymentLine->tenant), 'jobInfo');
            if ($paymentLine) {
                $this->sendPaymentLineNotification($paymentLine);
                $paymentLine->invoiced = true;
                $paymentLine->save(false);
            }

        } catch (\Exception $e) {
            Yii::error('Job failed: ' . $e->getMessage(), 'jobErrors');
        }
    }

    // Send Email Notication

    public function sendPaymentLineNotification($paymentLine)
    {
        Yii::error($paymentLine->tenant);
        // Construct the email content based on payment line data
        $subject = "Payment Notification for Invoice #" . 'KAV-INV-' . $paymentLine->id;
        $body = "Dear " . $paymentLine->tenant->principle_tenant_name . ", \n\nWe are notifying you about your invoice #" . 'KAV-INV-' . $paymentLine->id .
            " with a rent amount of " . Yii::$app->formatter->asCurrency($paymentLine->agreed_rent_payable + $paymentLine->water_bill + $paymentLine->service_charge, 'Ksh.') .
            "\n\n Break Down:" .
            "\n\n Rent: " . Yii::$app->formatter->asCurrency($paymentLine->agreed_rent_payable, 'Ksh.') .
            "\n\n Water: " . Yii::$app->formatter->asCurrency($paymentLine->water_bill, 'Ksh.') . ' Units consumed: ' . $paymentLine->units_used .
            "\n\n Garbage: " . Yii::$app->formatter->asCurrency($paymentLine->service_charge, 'Ksh.') .

            "\n\n Total: " . Yii::$app->formatter->asCurrency($paymentLine->agreed_rent_payable + $paymentLine->water_bill + $paymentLine->service_charge, 'Ksh.') .

            ".\n\nThank you for your attention.";
        Yii::info('Successfull billing for : ' . $body, 'jobInfo');
        try {
            // Use Yii's mailer component to send the email
            Yii::$app->mailer->compose()
                ->setFrom('billing@yourdomain.com')
                ->setTo($paymentLine->tenant->billing_email_address)  // Assuming each line has an associated customer email
                ->setSubject($subject)
                ->setTextBody($body)
                ->send();

            return ['status' => 'success', 'invoice_id' => $paymentLine->id];
        } catch (\Exception $e) {
            // Log and return the error message
            Yii::error("Error sending email for invoice #" . $paymentLine->id . ": " . $e->getMessage(), 'jobErrors');
            return ['status' => 'failure', 'invoice_id' => $paymentLine->id, 'error' => $e->getMessage()];
        }
    }
}