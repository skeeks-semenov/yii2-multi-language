<?php
/**
 * @link https://cms.skeeks.com/
 * @copyright Copyright (c) 2010 SkeekS
 * @license https://cms.skeeks.com/license/
 * @author Semenov Alexander <semenov@skeeks.com>
 */

namespace skeeks\yii2\multiLanguage;

use Yii;
use yii\base\InvalidConfigException;
use yii\web\Application;
use yii\web\Request;

/**
 * @author Semenov Alexander <semenov@skeeks.com>
 */
class MultiLangRequest extends Request
{

    /**
     * @var
     */
    private $_lang_url;

    /**
     * @return bool|string
     * @throws InvalidConfigException
     */
    public function getLangUrl()
    {
        if (!\Yii::$app instanceof Application)
        {
            return '';
        }

        if ($this->_lang_url === null) {
	        $this->_lang_url = $this->getUrl();

	    	$url_list = explode('/', $this->_lang_url);

	    	$lang_url = isset($url_list[1]) ? $url_list[1] : null;

            if ($lang_url == \Yii::$app->multiLanguage->default_lang)
            {
                return $this->_lang_url;
            }

            if (!in_array($lang_url, \Yii::$app->multiLanguage->langs))
            {
                return $this->_lang_url;
            }

            \Yii::$app->language = $lang_url;
            \Yii::$app->setHomeUrl(\Yii::$app->homeUrl . $lang_url);

                if( $lang_url !== null && $lang_url === $lang_url &&
				strpos($this->_lang_url, $lang_url) === 1 )
                {
                     $this->_lang_url = substr($this->_lang_url, strlen($lang_url)+1);
                }
        }

        return $this->_lang_url;
    }

    protected function resolvePathInfo()
    {
        $pathInfo = $this->getLangUrl();

        if (($pos = strpos($pathInfo, '?')) !== false) {
            $pathInfo = substr($pathInfo, 0, $pos);
        }

        $pathInfo = urldecode($pathInfo);

        // try to encode in UTF8 if not so
        // http://w3.org/International/questions/qa-forms-utf-8.html
        if (!preg_match('%^(?:
            [\x09\x0A\x0D\x20-\x7E]              # ASCII
            | [\xC2-\xDF][\x80-\xBF]             # non-overlong 2-byte
            | \xE0[\xA0-\xBF][\x80-\xBF]         # excluding overlongs
            | [\xE1-\xEC\xEE\xEF][\x80-\xBF]{2}  # straight 3-byte
            | \xED[\x80-\x9F][\x80-\xBF]         # excluding surrogates
            | \xF0[\x90-\xBF][\x80-\xBF]{2}      # planes 1-3
            | [\xF1-\xF3][\x80-\xBF]{3}          # planes 4-15
            | \xF4[\x80-\x8F][\x80-\xBF]{2}      # plane 16
            )*$%xs', $pathInfo)
        ) {
            $pathInfo = utf8_encode($pathInfo);
        }

        $scriptUrl = $this->getScriptUrl();
        $baseUrl = $this->getBaseUrl();
        if (strpos($pathInfo, $scriptUrl) === 0) {
            $pathInfo = substr($pathInfo, strlen($scriptUrl));
        } elseif ($baseUrl === '' || strpos($pathInfo, $baseUrl) === 0) {
            $pathInfo = substr($pathInfo, strlen($baseUrl));
        } elseif (isset($_SERVER['PHP_SELF']) && strpos($_SERVER['PHP_SELF'], $scriptUrl) === 0) {
            $pathInfo = substr($_SERVER['PHP_SELF'], strlen($scriptUrl));
        } else {
            throw new InvalidConfigException('Unable to determine the path info of the current request.');
        }

        if (isset($pathInfo[0]) && $pathInfo[0] === '/') {
            $pathInfo = substr($pathInfo, 1);
        }

        //print_r($pathInfo);die;
        return (string) $pathInfo;
    }
}