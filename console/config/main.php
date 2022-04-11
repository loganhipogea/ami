<?php
require __DIR__ . '/../../common/config/bootstrap.php';
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
        '@npm'   => '@vendor/npm-asset',
    ],
    'modules'=>[
         'telegram' => [
        'class' => 'onmotion\telegram\Module',
        'API_KEY' => '1989528761:AAFAosVxQS447NVDEXHit3Xr9ACUsk1oaoI',
        'BOT_NAME' => 'vikocaricia',
        'hook_url' => 'https://www.diarplataforma.com/frontend/web/telegram/default/hook', // must be https! (if not prettyUrl https://yourhost.com/index.php?r=telegram/default/hook)
        'PASSPHRASE' => 'frase_para_login',
        // 'db' => 'db2', //db file name from config dir
        // 'userCommandsPath' => '@app/modules/telegram/UserCommands',
        // 'timeBeforeResetChatHandler' => 60
    ],
    ],
    
   'controllerMap' => [
       /* 'migrate' => [
                        'class' =>
                    'yii\console\controllers\MigrateController',
                      //'migrationPath'=>null,
                        'migrationNamespaces' => [
                            /*Ojo:
                             * Al aplicar estos namespaces
                             * Todos los archivos de migraciones tienen
                             * que tner declarado su namespace en 
                             * la cabecera de otro modo habra error 
                             * al momento de ejecutar la migracion 
                             */
                            //'mdm\admin\migrations',
                          
                        
                       // 'backend\database\migrations', 
                        // 'frontend\modules\import\database\migrations', 
                           // 'mdm\admin\migrations',
                            //'yii/rbac/migrations',
                            //'yii/log/migrations',
                           // 'vendor/yii2mod/yii2-settings/migrations/',
                             //'nemmo\attachments\migrations', 
                         // 'frontend\modules\inter\database\migrations', 
                           // 'frontend\modules\import\database\migrations', 
                           // 'console\migrations',
                          /*   'yii2mod\settings\migrations',  
                          'backend\database\migrations', 
                           'frontend\database\migrations',  
                             //'frontend\modules\message\database\migrations',
                          'nemmo\attachments\migrations', 
                          //'yii\rbac\migrations', 
                          
                        // 'nemmo\attachments\migrations',   
                           'mdm\admin\migrations',
                         //'frontend\modules\people\database\migrations',
                        // 'frontend\modules\bigitems\database\migrations', 
                        // 'frontend\modules\report\database\migrations',
                          'frontend\modules\import\database\migrations',
                            //'frontend\modules\sta\database\migrations',
                           // 'frontend\modules\sigi\database\migrations',
                             //'frontend\modules\access\database\migrations',
                            //'frontend\modules\avisos\database\migrations',
                            
                            ],
                        ],*/
        'migrate-core' => [
            'class' => 'yii\console\controllers\MigrateController',
             'migrationPath'=>[
                '@yii/rbac/migrations',
                '@mdm/admin/migrations',
                '@yii/log/migrations',
                '@vendor/yii2mod/yii2-settings/migrations/',
                '@vendor/nemmo/yii2-attachments/migrations',
                ],
            'migrationNamespaces' => ['nemmo\attachments\migrations'],
            'migrationTable' => 'migration_rbac',
            //'migrationPath' => null,
        ],
        
        'migrate-general' => [
            'class' => 'yii\console\controllers\MigrateController',
            'migrationPath' => ['console\migrations'],
           // 'migrationTable' => 'migration_app',
            //'migrationPath' => null,
        ],
        
        // Migrations for the specific project's module
        'migrate-modules' => [
           'class' => 'yii\console\controllers\MigrateController',
            'migrationNamespaces' => [
                'frontend\modules\sigi\database\migrations',
                'frontend\modules\cc\database\migrations',
                'frontend\modules\import\database\migrations',
                'frontend\modules\report\database\migrations',
                 'frontend\modules\mat\database\migrations',
                'frontend\modules\op\database\migrations',
                //'frontend\modules\regacad\database\migrations',
               // 'frontend\modules\repositorio\database\migrations',
                //'frontend\modules\acad\database\migrations',
               // 'backend\modules\base\database\migrations',
                
                ],
            'migrationTable' => 'migration_module',
            'migrationPath' => null,
        ],
        // Migrations for the specific extension
        
        
        'fixture' => [
            'class' => 'yii\console\controllers\FixtureController',
            'namespace' => 'common\fixtures',
          ],
    ],
    'components' => [
        
        
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
         'user' => [
       'class' => 'mdm\admin\models\User',
        'identityClass' => 'mdm\admin\models\User',
        'loginUrl' => ['admin/user/login'],
         ],
         'log' => [
                //'traceLevel' => YII_DEBUG ? 3 : 0,            
            'targets' => [
                [
                    'class' => 'yii\log\DbTarget',
                    'levels' => ['trace','error', 'warning','info'],
                ],
               /* [
                    'class' => 'yii\log\EmailTarget',
                    'levels' => ['error'],
                    'categories' => ['yii\db\*'],
                    'message' => [
                       'from' => ['log@example.com'],
                       'to' => ['admin@example.com', 'developer@example.com'],
                       'subject' => 'Database errors at example.com',
                    ],
                ],*/
            ],
        ],
    ],
    'params' => $params,
];
