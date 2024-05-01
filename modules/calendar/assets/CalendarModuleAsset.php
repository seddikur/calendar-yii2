<?php

namespace app\modules\calendar\assets;


use app\common\base\ModuleAssetBundle;
use yii\web\YiiAsset;

/**
 * Class CalendarModuleAsset
 */
final class CalendarModuleAsset extends ModuleAssetBundle
{

    public function init(): void
    {
        parent::init();

        $this->css[] = 'css/calendar-module.css';


        // Common scripts
        $this->js[] = 'js/calendar-common.js';

//        $this->depends[] = NotyAsset::class;
//        $this->depends[] = DateTimePickerAsset::class;

    }
}
