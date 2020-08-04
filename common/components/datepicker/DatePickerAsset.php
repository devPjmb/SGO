<?php
/**
 * @copyright Copyright (c) 2015 Roman Ovchinnikov
 * @link https://github.com/RomeroMsk
 * @version 1.1.0
 */
namespace common\components\datepicker;

use yii\web\AssetBundle;

/**
 * DatePicker asset
 *
 * @author Roman Ovchinnikov <nex.software@gmail.com>
 * @link https://github.com/RomeroMsk/yii2-datepicker
 */
class DatePickerAsset extends AssetBundle
{
    public $sourcePath = '@bower/datepicker';

    public $depends = [
        'yii\bootstrap\BootstrapPluginAsset',
        'common\components\datepicker\MomentAsset',
    ];

    public function init() {
        if (YII_DEBUG) {
            $this->css[] = 'build/css/bootstrap-datetimepicker.css';
            $this->js[] = 'src/js/bootstrap-datetimepicker.js';
        } else {
            $this->css[] = 'build/css/bootstrap-datetimepicker.min.css';
            $this->js[] = 'build/js/bootstrap-datetimepicker.min.js';
        }
    }
}
