<?php
return [
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm' => '@vendor/npm-asset',
    ],
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'bootstrap' => [
        'queue',
    ],
    'components' => [
        'db' => [
            'class' => \yii\db\Connection::class,
            'dsn' => 'mysql:host=' . env('DB_HOST') . ';dbname=' . env('DB_NAME') . ';port=' . env('DB_PORT'),
            'username' => env('DB_USER'),
            'password' => env('DB_PASSWORD'),
            'charset' => 'utf8',
        ],
        'cache' => [
            'class' => \yii\caching\FileCache::class,
        ],
        'utility' => [
            'class' => \common\Library\UtilityComponent::class,
        ],
        'dashboard' => [
            'class' => \common\Library\DashboardComponent::class,
        ],
        'queue' => [
            'class' => \yii\queue\db\Queue::class,
            'db' => 'db', // DB connection component or its config 
            'tableName' => '{{%queue}}', // Table name
            'channel' => 'default', // Queue channel key
            'ttr' => 300,
            'attempts' => 3,
            'mutex' => \yii\mutex\MysqlMutex::class, // Mutex used to sync queries
        ],
        'log' => [
            'targets' => [
                [
                    'class' => \yii\log\FileTarget::class,
                    'levels' => ['error', 'warning'],
                    'categories' => ['jobErrors'], // Custom category for job errors
                    'logFile' => '@runtime/logs/job-errors.log', // Path to the log file
                    'logVars' => [], // Exclude variables like $_SERVER, $_POST, etc., if unnecessary
                    'maxFileSize' => 10240, // Maximum log file size in KB
                    'maxLogFiles' => 10, // Number of log files to keep
                ],
            ],
        ],
    ],
];
