<?php

/**
 * Created by PhpStorm.
 * User: HP ELITEBOOK 840 G5
 * Date: 2/20/2020
 * Time: 10:52 AM
 */

namespace common\helpers;

use yii\di\Container;

class Sms_Sender
{
    /**
     * @param $to
     * @param $msg
     * @return bool
     */

    //Was a static method
    public function sendSms($to, $msg)
    {
        $container = new Container;

        $container->set('sms', [
            'class' => 'common\Library\Sms',
            'params' => [
                'username' => env('SMS_USERNAME'),
                'key' => env('SMS_KEY'),
            ],
        ]);
        $class = $container->get('sms');

        try {
            return $class->sendMessage([
                'to' => $to,
                'sms' => $msg,
            ]);
        } catch (\AfricasTalkingGatewayException $e) {
            return false;
        }
    }
}
