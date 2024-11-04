<?php

namespace frontend\modules\apiv1\controllers;

use yii\filters\VerbFilter;
use yii\rest\ActiveController;

class PaymentlinesController extends ActiveController
{

    public $modelClass = '\common\models\Paymentlines';

    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'create' => ['POST'],
                    'update' => ['PUT', 'PATCH'],
                    'delete' => ['DELETE'],
                ],
            ],
        ];
    }
}