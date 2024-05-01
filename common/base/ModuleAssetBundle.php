<?php
//declare(strict_types=1);

namespace app\common\base;

use ReflectionClass;
use yii\helpers\VarDumper;
use yii\web\AssetBundle as BaseAssetBundle;

/**
 * Базовый класс ассетов для использования в модулях.
 * Позволяет сконцентрировать все файлы, используемые только в модуле, хранить в папке модуля.
 *
 * Должен использоваться в случае размещения ассетов непосредственно в папках модулей.
 * Позволяет автоматически определять относительные пути к файлам ассетов модуля на основании пути к классу
 * при условии соблюдения соответствующей файловой структуры:
 *
 * module <= Директория модуля
 * |-- assets
 *     |-- dist <= директория, являющаяся `sourcePath` для AssetBundle-классов модуля
 *     |   |-- js <= пример директории, содержащий JavaScript ассеты.
 *     |   |-- css <= пример директории, содержащий JavaScript ассеты.
 *     |   |-- img <= пример директории, содержащий вшитые изображения модуля.
 *     |   |-- fonts <= пример директории, содержащий шрифты модуля.
 *     |   |-- ... <= любое количество дополнительных директорий
 *     |
 *     |-- src  <= папка с сорцами файлов ассетов, если используются препроцессоры (SASS, Less, CoffeeScript etc.)
 *     |-- SomeModuleAsset.php <= Пример AssetBundle-класса ассета
 *     |-- OneMoreModuleAsset.php <= Пример AssetBundle-класса ассета
 *     |-- ... <= любое количество AssetBundle-классов
 *
 * Пример одного AssetBundle-класса модуля при использовании вышеуказанной структуры папок:
 *
 * ```
 * class SomeModuleAsset extends \common\base\ModuleAssetBundle
 * {
 *    public function init()
 *    {
 *        parent::init();
 *        $this->js[] = 'js/scripts.js';
 *        $this->css[] = 'css/styles.css';
 *        $this->depends[] = 'yii\web\YiiAsset';
 *    }
 * }
 * ```
 *
 * Получить доступ к директориям остальных типов ассетов можно в любом месте, где есть доступ к \yii\web\View объекту
 * ```
 * $class = SomeModuleAsset::class;
 * $assetDistDirPath = $view->registerAssetBundle($class);
 * $fontsDir =  $assetDistDirPath . '/fonts';
 * $imgDir =  $assetDistDirPath . '/img';
 * ```
 *
 */
class ModuleAssetBundle extends BaseAssetBundle
{
    /**
     * @inheritdoc
     */
    public function init(): void
    {
//        $this->publishOptions['forceCopy'] = (YII_ENV === 'dev');

        if (empty($this->sourcePath)) {
            $rc = new ReflectionClass($this);
            $fileName = $rc->getFileName();
            $this->sourcePath = \dirname($fileName) . '/dist';
        }
        parent::init();
    }
}
