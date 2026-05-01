<?php

namespace frontend\modules\apiv1\controllers;

use yii\filters\VerbFilter;
use yii\rest\ActiveController;

class AssociatedpaymentsController extends ActiveController
{
    public $modelClass = '\common\models\AssociatedPayments';


}