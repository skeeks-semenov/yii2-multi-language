<?php
/**
 * @link https://cms.skeeks.com/
 * @copyright Copyright (c) 2010 SkeekS
 * @license https://cms.skeeks.com/license/
 * @author Semenov Alexander <semenov@skeeks.com>
 */

namespace skeeks\yii2\multiLanguage;


use yii\helpers\ArrayHelper;
use yii\web\UrlManager;

/**
 * @author Semenov Alexander <semenov@skeeks.com>
 */
class MultiLangUrlManager extends UrlManager
{
    /**
     *
     */
    const LANG_PARAM_NAME = "lang";

    /**
     * @param array|string $params
     * @return string
     */
    public function createUrl($params)
    {
        if (isset($params[static::LANG_PARAM_NAME])) {
            //Если указан идентификатор языка, то делаем попытку найти язык в БД,
            //иначе работаем с языком по умолчанию
            $lang = $params[static::LANG_PARAM_NAME];
            unset($params[static::LANG_PARAM_NAME]);
        } else {
            //Если не указан параметр языка, то работаем с текущим языком
            $lang = \Yii::$app->language;
            //$lang = 'ru';
        }

        //Получаем сформированный URL(без префикса идентификатора языка)
        $url = parent::createUrl($params);

        if ($lang == \Yii::$app->multiLanguage->default_lang) {
            return $url;
        }

        //Url absolute
        if (strpos($url, '://') !== false) {
            $urlData = parse_url($url);
            $path = ArrayHelper::getValue($urlData, 'path');
            if ($path == "/") {
                $path = "";
            }
            $urlData['path'] = "/".$lang.$path;
            return $this->unparse_url($urlData);
        } else if (strpos($url, '//') !== false) {
            $urlData = parse_url($url);
            $path = ArrayHelper::getValue($urlData, 'path');
            if ($path == "/") {
                $path = "";
            }
            $urlData['path'] = "/".$lang.$path;
            return "//".$this->unparse_url($urlData);

        } else {
            if ($url == '/' || $url == '') {
                return '/'.$lang;
            } else {
                return '/'.$lang.$url;
            }
        }
    }

    /**
     * @param $parsed_url
     * @return string
     */
    static public function unparse_url($parsed_url)
    {
        $scheme = isset($parsed_url['scheme']) ? $parsed_url['scheme'].'://' : '';
        $host = isset($parsed_url['host']) ? $parsed_url['host'] : '';
        $port = isset($parsed_url['port']) ? ':'.$parsed_url['port'] : '';
        $user = isset($parsed_url['user']) ? $parsed_url['user'] : '';
        $pass = isset($parsed_url['pass']) ? ':'.$parsed_url['pass'] : '';
        $pass = ($user || $pass) ? "$pass@" : '';
        $path = isset($parsed_url['path']) ? $parsed_url['path'] : '';
        $query = isset($parsed_url['query']) ? '?'.$parsed_url['query'] : '';
        $fragment = isset($parsed_url['fragment']) ? '#'.$parsed_url['fragment'] : '';
        return "$scheme$user$pass$host$port$path$query$fragment";
    }
}