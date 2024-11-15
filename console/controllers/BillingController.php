<?php

namespace console\controllers;

use Yii;
use yii\console\ExitCode;
use yii\helpers\VarDumper;
use common\models\Schedule;
use yii\console\Controller;
use common\models\Payperiod;
use common\models\Paymentheader;

class BillingController extends Controller
{
    // Generate payperiods 
    public function actionBill()
    {
        // current day of the month
        $today = (int) (new \DateTime())->format('j');
        // Fetch all scheduling entries for current day
        $schedules = Schedule::find()
            ->where(['DAY(billing_date)' => $today])
            ->all();

        // foreach schedule generate: - payperiod -> paymentheader(voucher) -> invoice

        if ($schedules) {
            foreach ($schedules as $schedule) {
                // Check if a pay period for this estate and month already exists
                $payPeriodExists = Payperiod::find()
                    ->where(['estate_id' => $schedule->estate_id, 'payperiod_date' => date('Y-m-d')])
                    ->exists();

                if (!$payPeriodExists) {
                    $payperiod = new Payperiod();
                    $payperiod->property_id = $schedule->estate_id;
                    $payperiod->body = 'Invoice for period ending -' . date('F Y');
                    $payperiod->period = date('Y-m-d');
                    if ($payperiod->save()) {
                        // Generate a paymentheader
                        $paymentHeader = new Paymentheader();
                        $paymentHeader->payperiod_id = $payperiod->id;
                        $paymentHeader->property_id = $payperiod->property_id;
                        if ($paymentHeader->save()) {
                            Yii::info('Billing Voucher for ' . $payperiod->body . ' has been created successfully', 'jobInfo');
                        } else {
                            Yii::error('Error creating Payment header for ' . $payperiod->body . ' - no billing voucher was hence created.', 'jobInfo');
                        }
                    } else {
                        Yii::error('Error creating payperiod - ' . VarDumper::dump($payperiod->errors), 'jobInfo');
                    }
                }
            }


        }

    }

}
