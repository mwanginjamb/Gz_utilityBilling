<?php
use Faker\Factory;
use common\models\Unit;
use yii\helpers\ArrayHelper;

$faker = Factory::create();

$agreement = [true, false];
$water = [90, 100, 110];
$rent = [16000, 22000, 28000];

$units = Unit::find()->select(['id'])->asArray()->all();
$indexed = ArrayHelper::index($units, 'id');
$unit_keys = array_keys($indexed);

return [
    'user_id' => 1,
    'principle_tenant_name' => $faker->name(),
    'house_number' => $faker->randomElement($unit_keys), // @todo
    'cell_number' => $faker->e164PhoneNumber(),
    'billing_email_address' => $faker->email(),
    'id_number' => $faker->randomNumber(8, true),
    'agreed_rent_payable' => $faker->randomElement($rent),
    'agreed_water_rate' => $faker->randomElement($water),
    'has_signed_tenancy_agreement' => $faker->randomElement($agreement),

];