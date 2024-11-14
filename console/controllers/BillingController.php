<?php

namespace console\controllers;

use yii\console\Controller;
use yii\console\ExitCode;

class BillingController extends Controller
{
    public function actionBill()
    {
        $currentTime = \Yii::$app->formatter->asDateTime(date('Y-m-d H:i:s'));
        echo "Current time and day: $currentTime\n";

        return ExitCode::OK;
    }
}
