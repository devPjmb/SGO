<?php
return [
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'pdf' => [
            'class' => 'common\components\Dompdf\YiiDpdf',
            'HTML5enable' => true,
            'RemoteEnable' => true,
            'FontDefault' => 'Helvetica',
               
        ],
        'AccessControl' => [
            'class' => 'common\components\MyAccessControl',
        ],
      'urlManager' => [
        'class' => 'yii\web\UrlManager',
        // Disable index.php
        'showScriptName' => false,
        // Disable r= routes
        'enablePrettyUrl' => true,
        'rules' => [
                    '<controller:\w+>/<id:\d+>' => '<controller>/view',
                    '<controller:\w+>/<action:\w+>/<id:\d+>' => '<controller>/<action>',
                    '<controller:\w+>/<action:\w+>' => '<controller>/<action>',
                ],
        ],

      
       ],
];
