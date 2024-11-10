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
        Yii::info('Invoicing line: ' . VarDumper::dumpAsString($paymentLine->id), 'jobInfo');
        // Construct the email content based on payment line data
        $subject = "Payment Notification for Invoice #" . 'KAV-INV-' . $paymentLine->id;

        Yii::info('Successfull billing for invoice : ' . $paymentLine->id, 'jobInfo');
        try {
            // Use Yii's mailer component to send the email
            $mail = Yii::$app
                ->mailer
                ->compose(
                    ['html' => 'emailInvoice-html'],
                    ['paymentLine' => $paymentLine]
                )
                ->setFrom(env('SMTP_USERNAME'))
                ->setTo($paymentLine->tenant->billing_email_address)  // Assuming each line has an associated customer email
                ->setSubject($subject)
                ->send();
            Yii::info('Invoice mailed successfully : ' . VarDumper::dumpAsString($mail), 'jobInfo');
            return ['status' => 'success', 'invoice_id' => $paymentLine->id];
        } catch (\Exception $e) {
            // Log and return the error message
            Yii::error("Error sending email for invoice #" . $paymentLine->id . ": " . $e->getMessage(), 'jobErrors');
            return ['status' => 'failure', 'invoice_id' => $paymentLine->id, 'error' => $e->getMessage()];
        }
    }
}