<?php
namespace common\jobs;

use Yii;
use yii\base\BaseObject;
use yii\helpers\VarDumper;
use yii\queue\JobInterface;
use common\models\Paymentlines;

class SendSmsJob extends BaseObject implements JobInterface
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
                if ($this->sendPaymentLineNotification($paymentLine)) {
                    $paymentLine->invoiced = true;
                    $paymentLine->save(false);
                }
            }

        } catch (\Exception $e) {
            Yii::error('Job failed: ' . $e->getMessage(), 'jobErrors');
        }
    }

    // Send Email Notication

    public function sendPaymentLineNotification($paymentLine)
    {
        Yii::info('Invoicing line: ' . $paymentLine->id, 'jobInfo');
        // Construct the email content based on payment line data

        try {
            $verifyLink = env('APP_BASE_URL', 'http://utility.com') . '/tenant/view-invoice?invoiceid=' . $paymentLine->id;
            $billingType = $paymentLine->paymentheader->property->billing_type;
            $rent = ($billingType == 'composite' || $billingType == 'rent') ? Yii::$app->formatter->asCurrency($paymentLine->agreed_rent_payable, 'Ksh.') . '\r\n' : '';
            $utilities = ($billingType == 'composite' || $billingType == 'utilities') ? Yii::$app->formatter->asCurrency($paymentLine->water_bill, 'Ksh.') . '\r\n' : '';
            $service_charge = ($billingType == 'composite' || $billingType == 'service_charge') ? Yii::$app->formatter->asCurrency($paymentLine->service_charge, 'Ksh.') . '\r\n' : '';

            $subject = "Bill Notification for Invoice #" . ' Unit - ' . $paymentLine->id . '\r\n';
            $charges = $rent . $utilities . $service_charge;
            $total = Yii::$app->formatter->asCurrency($paymentLine->agreed_rent_payable + $paymentLine->water_bill + $paymentLine->service_charge, 'Ksh.') . '\r\n';
            $link = '\r\n Verify invoice via this link: ' . $verifyLink;
            $smsText = $subject . $charges . $total . $link;

            $no = '+254' . $paymentLine->tenant->cell_number;

            Yii::$app->sms->sendSms($no, $smsText);

            Yii::info('Job Log: SMS Invoice successfully ', 'sms');
            // return ['status' => 'success', 'invoice_id' => $paymentLine->id];
        } catch (\Exception $e) {
            // Log and return the error message
            Yii::error("Error sending sms invoice #" . $paymentLine->id . ": " . $e->getMessage(), 'sms');
            //  return ['status' => 'failure', 'invoice_id' => $paymentLine->id, 'error' => $e->getMessage()];
        }
    }
}