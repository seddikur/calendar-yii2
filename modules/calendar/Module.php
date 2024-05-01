<?php

namespace app\modules\calendar;
use yii\base\Module as BaseModule;
/**
 * Модуль класс определения модуля
 */
class Module extends BaseModule
{
    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'app\modules\calendar\controllers';

    /**
     * Конструктор.
     * @param string            $id     ID модуля
     * @param null|BaseModule   $parent Родительский модуль
     * @param array             $config пары имя-значение
     */
    public function __construct(
        string $id,
        ?BaseModule $parent = null,
        array $config = []
    )
    {
        parent::__construct($id, $parent, $config);
    }
    /**
     * Returns a title of the module
     * @return string
     */
    public function getTitle(): string
    {
        return 'Календарь';
    }
}
