<?php

namespace app\modules\calendar\controllers;

use yii\web\Controller;
use app\modules\calendar\Module;
use app\modules\calendar\assets\CalendarAsset;

/**
 * Default controller for the `Module` module
 */
class DefaultController extends Controller
{

    /**
     * @param string $id
     * @param Module $module
     * @param array  $config
     * @throws \yii\base\InvalidConfigException
     */
    public function __construct(string $id, Module $module, array $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->getView()->registerAssetBundle(CalendarAsset::class);
    }


    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }
}
