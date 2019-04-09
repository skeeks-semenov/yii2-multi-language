<?php
/**
 * @link https://cms.skeeks.com/
 * @copyright Copyright (c) 2010 SkeekS
 * @license https://cms.skeeks.com/license/
 * @author Semenov Alexander <semenov@skeeks.com>
 */

namespace skeeks\yii2\multiLanguage;


use yii\base\BootstrapInterface;
use yii\base\Event;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\web\Application;
use yii\web\View;
/**
 * @property string $widgetSuffix
 *
 * @author Semenov Alexander <semenov@skeeks.com>
 */
class MultiLangComponent extends \yii\base\Component implements BootstrapInterface
{
    /**
     * @var array доступные языки
     */
    public $langs = ['ru', 'en'];

    /**
     * @var string язык проекта по умолчанию
     */
    public $default_lang = 'ru';

    /**
     * @var string
     */
    public $lang_param_name = 'lang';

    /**
     * @param \yii\base\Application $application
     */
    public function bootstrap($application)
    {
        if ($application instanceof Application) {
            $application->view->on(View::EVENT_BEGIN_BODY, function (Event $e) {
                foreach ($this->langs as $langCode)
                {
                    $urlData = [];
                    $params = \Yii::$app->request->getQueryParams();
                    if ($params)
                    {
                        $params = ArrayHelper::merge($params, [$this->lang_param_name => $langCode]);
                    } else
                    {
                        $params = ArrayHelper::merge([], [$this->lang_param_name => $langCode]);
                    }

                    $route = \Yii::$app->requestedRoute;
                    $urlData = ["/" . $route];

                    $urlData = ArrayHelper::merge($urlData, $params);

                    $e->sender->registerLinkTag([
                        'rel' => 'alternate',
                        'hreflang' => $langCode,
                        'href' => Url::to($urlData, true),
                    ]);
                }
            });
        }
    }
}