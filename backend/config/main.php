<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app-backend',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'backend\controllers',
    'bootstrap' => ['log'],
    'defaultRoute' => 'dashboard/index',
    // 'defaultRoute' => 'unit/index',
    'modules' => [
        'auth' => [
            'class' => 'common\modules\auth\Module',
        ],
        'gridview' => [
            'class' => '\kartik\grid\Module'
        ],
       /*'admin' => [
            'class' => 'mdm\admin\Module',
        ],*/
        'datecontrol' => [
            'class' => 'kartik\datecontrol\Module',

            // format settings for displaying each date attribute
            'displaySettings' => [
                'date' => 'dd-MM-yyyy',
                'time' => 'hh:mm:ss a',
                'datetime' => 'dd-MM-yyyy hh:mm:ss a',
            ],

            //format settings for saving each date attribute
            'saveSettings' => [
                'date' => 'Y-m-d',
                'time' => 'php:H:i:s',
                'datetime' => 'php:Y-m-d H:i:s',
            ],

            'displayTimezone' => 'Asia/Jakarta',
            'saveTimezone' => 'UTC',
            'autoWidget' => true,
            'autoWidgetSettings' => [
                'date' => ['type'=>2, 'pluginOptions'=>['autoclose'=>true]],
                'datetime' => [],
                'time' => [],
            ]
        ],
    ],
    'components' => [
        'user' => [
            'identityClass' => 'backend\models\User',
            'enableAutoLogin' => true,
            //'enableAutoLogin' => false,
            'identityCookie' => [
                'name' => '_backendUser',
            ],
        ],
        'session' => [
            'name' => 'PHPBACKSESSID',
            'savePath' => sys_get_temp_dir(),
        ],
        'request' => [
            'cookieValidationKey' => '[xHQcILKu3I8lBl5ifoQg]',
            'csrfParam' => '_backendCSRF',
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'authManager' => [
            'class' => 'yii\rbac\DbManager',
            'defaultRoles' => ['guest'],
        ],
        'urlManager' => [
            'showScriptName' => true,
        ],
        /*'as access' => [
            'class' => 'mdm\admin\components\AccessControl',
            'allowActions' => [
                //'site/*',
                'admin/*',
                //'some-controller/some-action',
            ]
        ],*/
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
    ],
    /*'aliases' => [
        '@mdm/admin' => '@app/extensions/mdm/yii2-admin-2.0.0',
    ],*/
    'params' => $params,
];
