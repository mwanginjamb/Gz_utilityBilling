<?php

/**
 * Created by PhpStorm.
 * User: HP ELITEBOOK 840 G5
 * Date: 3/10/2020
 * Time: 2:27 PM
 */

namespace common\Library;

use common\models\Property;
use yii;
use yii\base\Component;
use yii\helpers\ArrayHelper;


class DashboardComponent extends Component
{

    // count properties

    public function countProperties()
    {
        $properties = Property::find()->select(['id'])->asArray()->all();
        if ($properties) {
            return count($properties);
        }

        return 0;
    }

}
