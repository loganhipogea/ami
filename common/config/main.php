<?php
///https://www.yiiframework.com/extension/yii2-backuprestore
///https://www.yiiframework.com/extension/yii2-nprogress
///https://www.yiiframework.com/extension/yii2-widget-growl

///https://www.yiiframework.com/extension/yii2-showloading
///https://www.yiiframework.com/extension/yii2-export
///https://www.yiiframework.com/extension/yii2-backup
//http://demos.krajee.com/context-menu
return [
    
   
    
     'timeZone' => 'America/Lima',
   'name'=>'Diar gestión',
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
    'formatter' => [
        'class' => 'yii\i18n\Formatter',
        'nullDisplay' => '',
            'decimalSeparator' => '.',
            'thousandSeparator' => ',',
       ],
    ],
    
  /* 'as access' => [
        'class' => 'mdm\admin\components\AccessControl',
        'allowActions' => [
            'site/login*',  
             'site/logout*', 
        ]
    ],*/
    
    
   
    
    
    'modules' => [
       'modules' => [
        'op' => [
                    'class' => 'frontend\modules\op\OpModule',
                ],
             ],
        'mat' => [
            'class' => 'frontend\modules\mat\MatModule',
        ], 
        
        'message' => [
        'class' => 'frontend\modules\message\Module',
        'userModelClass' => '\common\models\User', // your User model. Needs to be ActiveRecord.
    ],
        
        'access' => [
            'class' => 'frontend\modules\access\accessModule',
        ],
        
        'sigi' => [
            'class' => 'frontend\modules\sigi\Module',
        ],
      
        
                'noty' => [
                'class' => 'lo\modules\noty\Module',
            ],
       
         'export' => [
                'class' => 'frontend\modules\export\ModuleExport',
            ],
        
        'import' => [
                'class' => 'frontend\modules\import\ModuleImport',
            ],
        'gridview' =>  [
        'class' => '\kartik\grid\Module'
        // enter optional module parameters below - only if you need to  
        // use your own export download action or custom translation 
        // message source
        // 'downloadAction' => 'gridview/export/download',
        // 'i18n' => []
        ],
        
        'attachments' => [
		'class' => nemmo\attachments\Module::className(),
		'tempPath' => '@common/uploads/temp',
		'storePath' => '@common/uploads/store',
		'rules' => [ // Rules according to the FileValidator
		    'maxFiles' => 10, // Allow to upload maximum 3 files, default to 3
		//'mimeTypes' => 'image/png', // Only png images
			'maxSize' => 10  // 1 MB
		],
		'tableName' => '{{%attachments}}' // Optional, default to 'attach_file'
	],
         'reportico' => [
            'class' => 'reportico\reportico\Module' ,
            'controllerMap' => [
                           // 'reportico' => 'reportico\reportico\controllers\ReporticoController',
                           // 'mode' => 'reportico\reportico\controllers\ModeController',
                            //'ajax' => 'reportico\reportico\controllers\AjaxController',
                        ]
            ],
        
         'report' => [
            'class' => 'frontend\modules\report\Module',
        ],
        
    'admin' => [
                'class' => 'mdm\admin\Module',        
                ],
   
        'settings' => [
        'class' => 'yii2mod\settings\Module',
           //'cache' => 'yii\caching\Cache',//yii\caching\Cache
            ],
        
       
        'people' => [
            'class' => 'frontend\modules\people\Module',
        ],
	'bigitems' => [
            'class'=> 'frontend\modules\bigitems\Module',
        ],
        'materials' => [
            'class' => 'frontend\modules\materials\Module',
        ],
         'report' => [
            'class' => 'frontend\modules\report\Module',
        ],
        
        
           ],
    
    'components' => [
        
           
        

        'paramsGen'=>[
            'class'=>'common\components\ParametersGeneral',
        ],
        
        
         'assetManager' => [
        'bundles' => [
            
            'kartik\form\ActiveFormAsset' => [
                'bsDependencyEnabled' => false // do not load bootstrap assets for a specific asset bundle
          
                                 ],
            'yii\web\JqueryAsset' => [
                'jsOptions' => [ 'position' => \yii\web\View::POS_HEAD ],
            ],
            'yii\widgets\PjaxAsset' => [
                'jsOptions' => [ 'position' => \yii\web\View::POS_HEAD ],
            ],
        ],
    ],
        
        
        
        
         'i18n' => [
            'translations' => [
              
                        
                'rbac-admin'=>[
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@mdm/admin/messages',
                    'sourceLanguage' => 'en',
                ],
    

                'yii2mod.settings' => [
                                            'class' => 'yii\i18n\PhpMessageSource',
                                            'basePath' => '@yii2mod/settings/messages',
                                            ],    
                
                'report.messages' => [
                                            'class' => 'yii\i18n\PhpMessageSource',
                                            'basePath' => '@frontend/modules/report/messages',
                                            ], 
                
                'report.labels' => [
                                            'class' => 'yii\i18n\PhpMessageSource',
                                            'basePath' => '@frontend/modules/report/messages',
                                            ],  
                 'bigitems.labels' => [
                                            'class' => 'yii\i18n\PhpMessageSource',
                                            'basePath' => '@frontend/modules/bigitems/messages',
                                            ], 
                'import.labels' => [
                                            'class' => 'yii\i18n\PhpMessageSource',
                                            'basePath' => '@frontend/modules/import/messages',
                                            ], 
                'import.errors' => [
                                            'class' => 'yii\i18n\PhpMessageSource',
                                            'basePath' => '@frontend/modules/import/messages',
                                            ], 
                                              
                'import.messages' => [
                                            'class' => 'yii\i18n\PhpMessageSource',
                                            'basePath' => '@frontend/modules/import/messages',
                                            ], 
                'message' => [
                                            'class' => 'yii\i18n\PhpMessageSource',
                                            'basePath' => '@frontend/modules/message/messages',
                                            ], 
                'bigitems.errors' => [
                                            'class' => 'yii\i18n\PhpMessageSource',
                                            'basePath' => 'frontend\modules\bigitems\messages',
                                            ],
                
                'install.procedures' =>[
                                            'class' => 'yii\i18n\PhpMessageSource',
                                            'basePath' => '@messages',                                            
                                            ],
                
                                     'models.validations' =>[
                                            'class' => 'yii\i18n\PhpMessageSource',
                                            'basePath' => '@messages',                                            
                                            ],
                                      'models.labels' =>[
                                            'class' => 'yii\i18n\PhpMessageSource',
                                            'basePath' => '@messages',                                          
                                            ],                
                                     'models.errors' =>[
                                            'class' => 'yii\i18n\PhpMessageSource',
                                            'basePath' => '@messages',
                                           
                                            //'basePath' => '@app/messages',                                            
                                            ],
                                        'control.errors' =>[
                                            'class' => 'yii\i18n\PhpMessageSource',
                                            'basePath' => '@messages',                                          
                                            ],
                
                                    'base.errors' =>[
                                            'class' => 'yii\i18n\PhpMessageSource',
                                            'basePath' => '@messages',                                          
                                            ],
                             'base.names'=>[
                                 'class' => 'yii\i18n\PhpMessageSource',
                                 'basePath' => '@messages',                                          
                                            ],
                'base.labels'=>[
                                 'class' => 'yii\i18n\PhpMessageSource',
                                 'basePath' => '@messages',                                          
                                            ], 
                'base.forms'=>[
                                 'class' => 'yii\i18n\PhpMessageSource',
                                 'basePath' => '@messages',                                          
                                            ], 
                
                                   'base.actions'=>[
                                 'class' => 'yii\i18n\PhpMessageSource',
                                 'basePath' => '@messages',                                          
                                            ], 
                                         'base.errors'=>[
                                 'class' => 'yii\i18n\PhpMessageSource',
                                 'basePath' => '@messages',                                          
                                            ], 
                                            'base.verbs'=>[
                                 'class' => 'yii\i18n\PhpMessageSource',
                                 'basePath' => '@messages',                                          
                                            ], 
                 'sta.labels'=>[
                                 'class' => 'yii\i18n\PhpMessageSource',
                                 'basePath' => '@frontend/modules/sta/messages',                                         
                                            ], 
                'sta.actions'=>[
                                 'class' => 'yii\i18n\PhpMessageSource',
                                 'basePath' => '@frontend/modules/sta/messages',                                         
                                            ], 
                'sta.errors'=>[
                                 'class' => 'yii\i18n\PhpMessageSource',
                                 'basePath' => '@frontend/modules/sta/messages',                                         
                                        ], 
                'sta.messages'=>[
                                 'class' => 'yii\i18n\PhpMessageSource',
                                 'basePath' => '@frontend/modules/sta/messages',                                         
                                            ],  
                'sta.labels'=>[
                                 'class' => 'yii\i18n\PhpMessageSource',
                                 'basePath' => '@frontend/modules/sta/messages',                                         
                                            ], 
                'sigi.actions'=>[
                                 'class' => 'yii\i18n\PhpMessageSource',
                                 'basePath' => '@frontend/modules/sigi/messages',                                         
                                            ], 
                'sigi.errors'=>[
                                 'class' => 'yii\i18n\PhpMessageSource',
                                 'basePath' => '@frontend/modules/sigi/messages',                                         
                                        ], 
                'sigi.labels'=>[
                                 'class' => 'yii\i18n\PhpMessageSource',
                                 'basePath' => '@frontend/modules/sigi/messages',                                         
                                        ], 
                      ],
                  ],
        
   'settings' => [
        'class' => 'yii2mod\settings\components\Settings',
        'cache'=>['class'=>'yii\caching\FileCache'],
    ],
        
        
    'authManager' => [
         'class' => 'yii\rbac\DbManager', // or use 'yii\rbac\DbManager'
    ],
        'user' => [
         'class' => 'common\components\User',
        //'identityClass' => 'mdm\admin\models\User',
            'identityClass' => 'common\models\User',
        //'loginUrl' => ['admin/user/login'],
         'loginUrl' => ['site/login'],  
           'enableAutoLogin'=>false,
           // authTimeout
            'enableSession' => true,
            'authTimeout'=>60*40*5,
    ]
        
        
        
           ],
   
    
];
