<?php
namespace common\fixtures\templates;
use Faker\Factory;

$faker = Factory::create();

return [
    'name' => $faker->address(),
    'build_date' => $faker->date('Y-m-d'),
];