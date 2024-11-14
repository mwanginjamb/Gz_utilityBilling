<?php

namespace frontend\modules\apiv1\controllers;

use yii\filters\VerbFilter;
use yii\rest\ActiveController;

class TenantController extends ActiveController
{
    public $modelClass = '\common\models\Tenant';


}