<?php

namespace common\assets;

use yii\web\AssetBundle;

/**
 * Main backend application asset bundle.
 */
class AppAssetFullCalendar extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'js/fullcalendar/core/main.css',
        'js/fullcalendar/daygrid/main.css',
        'js/fullcalendar/timegrid/main.css',
    ];
    public $js = [
        'js/fullcalendar/core/main.js',
        'js/fullcalendar/interaction/main.js',
        'js/fullcalendar/daygrid/main.js',
        'js/fullcalendar/timegrid/main.js',
        
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
