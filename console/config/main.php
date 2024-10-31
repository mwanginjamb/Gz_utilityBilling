<?php
use yii\faker\FixtureController;

$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-console',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'console\controllers',
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm' => '@vendor/npm-asset',
    ],
    'controllerMap' => [
        'fixture' => [
            'class' => FixtureController::class,
            'namespace' => 'common\fixtures',
            'templatePath' => '@common/fixtures/templates',
            'fixtureDataPath' => '@common/fixtures/data',
        ],
        /* 'migrate' => [
             'class' => 'yii\console\controllers\MigrateController',
             'migrationPath' => null,
             'migrationNamespaces' => [
                 'yii\queue\db\migrations',
             ],
         ]*/
    ],
    'components' => [
        'log' => [
            'targets' => [
                [
                    'class' => \yii\log\FileTarget::class,
                    'levels' => ['error', 'warning'],
                ],
                [
                    'class' => \yii\log\FileTarget::class,
                    'levels' => ['error', 'warning', 'info'],
                    'categories' => ['jobErrors', 'jobInfo'], // Custom category for job errors
                    'logFile' => '@runtime/logs/job-errors.log', // Path to the log file
                    'logVars' => [], // Exclude variables like $_SERVER, $_POST, etc., if unnecessary
                    'maxFileSize' => 10240, // Maximum log file size in KB
                    'maxLogFiles' => 10, // Number of log files to keep
                ],
            ],
        ],
    ],
    'params' => $params,
];
