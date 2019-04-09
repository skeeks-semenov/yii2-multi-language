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
     * @param array|string $params
     * @return string
     */
    public function createUrl($params)
    {
        if (isset($params[\Yii::$app->multiLanguage->lang_param_name])) {
            $lang = $params[\Yii::$app->multiLanguage->lang_param_name];
            //unset($params[\Yii::$app->multiLanguage->lang_param_name]);
        } else {
            //Если не указан параметр языка, то работаем с текущим языком
            $lang = \Yii::$app->language;
            $params[\Yii::$app->multiLanguage->lang_param_name] = $lang;
            //$lang = 'ru';
        }


        //Если урл вида /url/test то нужно убрать из параметров язык, поскольку он будет содержатся не в параметра а в pathInfo
        if ($this->enablePrettyUrl) {
            unset($params[\Yii::$app->multiLanguage->lang_param_name]);
        }

        //Если указанный язык = отображаемому на сайте по умолчанию, то не нужно менять урл
        if ($lang == \Yii::$app->multiLanguage->default_lang) {
            return parent::createUrl($params);
        }

        /**
         * Работает только с enablePrettyUrl
         */
        if (!$this->enablePrettyUrl) {
            return parent::createUrl($params);
        }

        //Получаем сформированный URL(без префикса идентификатора языка)
        $url = parent::createUrl($params);

        /*print_r($lang);
        echo "\n";
        print_r($url);
        echo "\n";
        echo "\n";
        echo "\n";*/
        //Url absolute
        if (strpos($url, '://') !== false) {
            $urlData = parse_url($url);
            $path = ArrayHelper::getValue($urlData, 'path');
            if ($path == "/") {
                $path = "";
            }
            $urlData['path'] = "/" . $lang . $path;
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
            if ($url == '' || $url == "/") {
                //Поддерживаем только суффикс "/" для поддержки других суффиксов, нужно это учесть в MultiLangRequest
                if ($this->suffix == "/") {
                    $suffix = "/";
                } else {
                    $suffix = "";
                }
                return '/' . $lang . $suffix;
            } else {
                return '/' . $lang . $url;
            }
        }
    }

    /**
     * @param array|string $params
     * @param null         $scheme
     * @return string
     */
    public function createAbsoluteUrl($params, $scheme = null)
    {
        $tmpHostInfo = $this->hostInfo;
        $request = \Yii::$app->request;
        if ($request instanceof MultiLangRequest) {
            $request->getHostInfo();
            $this->hostInfo = $request->hostInfoNoLang;
        }
        $url = parent::createAbsoluteUrl($params, $scheme);
        $this->hostInfo = $tmpHostInfo;
        return $url;
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