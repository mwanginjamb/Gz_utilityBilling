<?php

/**
 * Created by PhpStorm.
 * User: HP ELITEBOOK 840 G5
 * Date: 2/20/2020
 * Time: 10:44 AM
 */

namespace common\Library;

use yii;
use yii\base\BaseObject;
use yii\helpers\VarDumper;
use yii\base\InvalidConfigException;

class Sms extends BaseObject
{
    protected $_username;
    protected $_apiKey;

    protected $_requestBody;
    protected $_requestUrl;

    protected $_responseBody;
    protected $_responseInfo;

    const SMS_URL = 'https://api.africastalking.com/version1/messaging';
    const VOICE_URL = 'https://voice.africastalking.com';
    const USER_DATA_URL = 'https://api.africastalking.com/version1/user';
    const SUBSCRIPTION_URL = 'https://api.africastalking.com/version1/subscription';
    const AIRTIME_URL = 'https://api.africastalking.com/version1/airtime';

    public $params;
    //Turn this on if you run into problems. It will print the raw HTTP response from our server
    const Debug = true;

    const HTTP_CODE_OK = 200;
    const HTTP_CODE_CREATED = 201;


    public function __construct(array $config = [])
    {
        parent::__construct($config);
        $this->_username = $config['params']['username'];
        $this->_apiKey = $config['params']['key'];
        $this->_requestBody = null;
        $this->_requestUrl = null;

        $this->_responseBody = null;
        $this->_responseInfo = null;
    }

    public function sendMessage($params)
    {
        $to_ = $params['to'];
        $message_ = $params['sms'];
        $from_ = null;
        $options_ = array();
        $options_ = array();
        if (strlen($to_) == 0 || strlen($message_) == 0) {
            throw new InvalidConfigException('Please supply both to and message parameters');
        }
        $params = array(
            'username' => $this->_username,
            'to' => $to_,
            'message' => $message_,
        );
        if ($from_ !== null) {
            $params['from'] = $from_;
            $params['bulkSMSMode'] = 1;
        }
        //This contains a list of parameters that can be passed in $options_ parameter
        if (count($options_) > 0) {
            $allowedKeys = array(
                'enqueue',
                'keyword',
                'linkId',
                'retryDurationInHours'
            );

            //Check whether data has been passed in options_ parameter
            foreach ($options_ as $key => $value) {
                if (in_array($key, $allowedKeys) && strlen($value) > 0) {
                    $params[$key] = $value;
                } else {
                    throw new InvalidConfigException("Invalid key in options array: [$key]");
                }
            }
        }
        $this->_requestUrl = self::SMS_URL;

        $this->_requestBody = http_build_query($params, '', '&');

        $this->executePOST();

        if ($this->_responseInfo['http_code'] == self::HTTP_CODE_CREATED) {
            $responseObject = json_decode($this->_responseBody);
            Yii::info('Recipient Info: ' . VarDumper::dump($responseObject->SMSMessageData->Recipients), 'sms');
            return $responseObject->SMSMessageData->Recipients;
        }

        throw new InvalidConfigException($this->_responseBody);
    }
    private function executePost()
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_POSTFIELDS, $this->_requestBody);
        curl_setopt($ch, CURLOPT_POST, 1);
        $this->doExecute($ch);
    }
    private function doExecute(&$curlHandle_)
    {
        try {

            $this->setCurlOpts($curlHandle_);
            $responseBody = curl_exec($curlHandle_);

            if (self::Debug) {
                Yii::info('Full response: ' . VarDumper::dump($responseBody), 'sms');
                echo "Full response: " . print_r($responseBody, true) . "\n";
            }

            $this->_responseInfo = curl_getinfo($curlHandle_);

            $this->_responseBody = $responseBody;
            curl_close($curlHandle_);
        } catch (\Exeption $e) {
            \Yii::error('sms Gateway error: ' . VarDumper::dumpAsString($e->getMessage()), 'sms');
            curl_close($curlHandle_);
            throw $e;
        }
    }
    private function setCurlOpts(&$curlHandle_)
    {
        curl_setopt($curlHandle_, CURLOPT_TIMEOUT, 60);
        curl_setopt($curlHandle_, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($curlHandle_, CURLOPT_URL, $this->_requestUrl);
        curl_setopt($curlHandle_, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curlHandle_, CURLOPT_HTTPHEADER, array(
            'Accept: application/json',
            'apikey: ' . $this->_apiKey
        ));
    }
}
