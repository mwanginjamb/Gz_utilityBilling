<?php

namespace frontend\modules\apiv1\controllers;

use yii\filters\VerbFilter;
use yii\rest\ActiveController;

class ScheduleController extends ActiveController
{
    public $modelClass = '\common\models\Schedule';


}