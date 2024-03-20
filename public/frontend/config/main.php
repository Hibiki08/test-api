<?php
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-frontend',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'frontend\controllers',
    'components' => [
        'user' => [
            'class' => \yii\web\User::class,
            'identityClass' => \common\models\Member::class,
            'loginUrl' => null,
            'enableSession' => false,
        ],
        'session' => [
            // this is the name of the session cookie used for login on the frontend
            'name' => 'advanced-frontend',
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'request' => [
            'class' => \yii\web\Request::class,
            'baseUrl' => '',
            'enableCsrfCookie' => false,
            'enableCsrfValidation' => false,
            'enableCookieValidation' => false,
            'parsers' => [
                'application/json' => 'yii\web\JsonParser',
            ],
        ],
        'response' => [
            'class' => \yii\web\Response::class,
            'format' => \yii\web\Response::FORMAT_JSON,
            'formatters' => [
                \yii\web\Response::FORMAT_JSON => [
                    'class' => 'yii\web\JsonResponseFormatter',
                    'prettyPrint' => YII_DEBUG,
                    'contentType' => \yii\web\JsonResponseFormatter::CONTENT_TYPE_JSON,
                ],
            ],
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                'app' => [
                    'class' => \yii\log\FileTarget::class,
                    'levels' => ['error', 'warning'],
                ],
                'info' => [
                    'class' => \yii\log\FileTarget::class,
                    'levels' => ['trace'],
                    'logFile' => strftime('@runtime/logs/info.log'),
                ],
            ],
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                'GET <module>/<controller>' => '<module>/<controller>/view',

                'POST <module>/<controller>/<slug:\w+>/<action>' => '<module>/<controller>/<action>',
            ],
        ],
        'mutex' => [
            'class' => 'yii\mutex\FileMutex',
        ],
    ],
    'modules' => [
        'v1' => [
            'class' => 'frontend\modules\v1\Module',
        ],
    ],
    'params' => $params,
];
