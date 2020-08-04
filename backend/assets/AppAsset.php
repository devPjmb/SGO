<?php

namespace backend\assets;

use yii\web\AssetBundle;

/**
 * Main backend application asset bundle.
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        /*'css/site.css',*/
//        'css/bootstrap.min.css',
//        'css/components-rounded.min.css',
//        'css/plugins.min.css',
//        'css/layout.min.css',
//        'css/custom.min.css',
//        'css/darkblue.min.css',
        'js/bootstrap-tagsinput-latest/src/bootstrap-tagsinput.css',
        'js/kartik-v-bootstrap-fileinput-58467aa/css/fileinput.min.css'
    ];
    public $js = [
        'js/bootstrap-tagsinput-latest/src/bootstrap-tagsinput.js',
        'js/kartik-v-bootstrap-fileinput-58467aa/js/fileinput.min.js',
//        'js/bootstrap.min.js',
//        'js/js.cookie.min.js',
//        'js/jquery.slimscroll.min.js',
//        'js/jquery.blockui.min.js',
//        'js/app.min.js',
//        'js/layout.min.js',
//        'js/demo.min.js',
//        'js/quick-sidebar.min.js',
//        'js/quick-nav.min.js',
        'ckeditor/ckeditor.js',
        'js/jsgeneral.js',
        'js/jsajax.js'
        
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
