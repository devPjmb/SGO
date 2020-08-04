<?php
/**
 * @copyright Federico Nicolás Motta
 * @author Federico Nicolás Motta <fedemotta@gmail.com>
 * @license http://opensource.org/licenses/mit-license.php The MIT License (MIT)
 * @package yii2-widget-datatables
 */
namespace common\components\datatables;


use yii\web\AssetBundle;

/**
 * Main backend application asset bundle.
 */
class Dtresponsive extends AssetBundle
{
    public $basePath = '@webroot';
    public $sourcePath  = '@bower/datatables/media';
    public $css = [
        'css/datatables.min.css',
    ];
    public $js = [
       'js/datatables.min.js',
 
        
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\web\JqueryAsset',
        // 'yii\bootstrap\BootstrapAsset',
    ];
}
