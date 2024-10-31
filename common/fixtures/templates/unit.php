<?php
namespace common\fixtures\templates;
use Faker\Factory;
use common\models\Property;
use yii\helpers\ArrayHelper;

$faker = Factory::create();

$properties = Property::find()->asArray(true)->all();
$property_ids = ArrayHelper::index($properties, 'id');
$keys = array_keys($property_ids);

return [
    'unit_name' => $faker->buildingNumber(),
    'property_id' => $faker->randomElement($keys),
];