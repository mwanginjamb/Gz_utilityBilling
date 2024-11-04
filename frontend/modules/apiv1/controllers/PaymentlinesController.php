<?php

namespace frontend\modules\apiv1\controllers;

use yii\filters\VerbFilter;
use yii\rest\ActiveController;

class PaymentlinesController extends ActiveController
{

    public $modelClass = '\common\models\Paymentlines';
    public $serializer = [
        'class' => 'yii/rest/Serializer',
        'collectionEnvelope' => 'item'
    ];
}