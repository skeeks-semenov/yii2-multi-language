<?php
/**
 * @link https://cms.skeeks.com/
 * @copyright Copyright (c) 2010 SkeekS
 * @license https://cms.skeeks.com/license/
 * @author Semenov Alexander <semenov@skeeks.com>
 */

namespace skeeks\yii2\multiLanguage;


/**
 * @property string $widgetSuffix
 *
 * @author Semenov Alexander <semenov@skeeks.com>
 */
class MultiLangComponent extends \yii\base\Component
{
    /**
     * @var array доступные языки
     */
    public $langs = ['ru', 'en'];

    /**
     * @var string язык проекта по умолчанию
     */
    public $default_lang = 'ru';
}