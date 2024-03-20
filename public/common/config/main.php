<?php
return [
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'cache' => [
            'class' => \yii\caching\FileCache::class,
        ],
        'authManager' => [
            'class' => 'yii\rbac\PhpManager',
            'itemFile' => '@common/config/rbac/items.php',
            'assignmentFile' => '@common/config/rbac/assignments.php',
            'ruleFile' => '@common/config/rbac/rules.php',
        ],
    ],
];
