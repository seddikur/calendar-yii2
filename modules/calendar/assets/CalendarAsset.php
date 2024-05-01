<?php
//declare(strict_types=1);

namespace app\modules\calendar\assets;

use app\common\base\ModuleAssetBundle;


final class CalendarAsset extends ModuleAssetBundle
{
    /**
     * @inheritdoc
     */
    public function init(): void
    {
        parent::init();

//        $this->js[] = 'js/calendar-page.js';

        $this->depends[] = CalendarModuleAsset::class;
    }
}
