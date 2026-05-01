<?php

namespace frontend\modules\apiv1\controllers;

use yii\filters\VerbFilter;
use yii\rest\ActiveController;

class InvoicelinesController extends ActiveController
{
    public $modelClass = '\common\models\Paymentlines';


}