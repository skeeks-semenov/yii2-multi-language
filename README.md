Component for multilingual site
================

[<img src="https://skeeks.com/uploads/all/4c/fd/50/4cfd50a535aef7c753b12c4adfbc0e33.png" alt="SkeekS blog" width="200"/>](https://skeeks.com/blog/programming/397-kak-preobrazovat-neaktivnye-ssylki-v-tekste-v-aktivnye-klikabelnye)

[![Latest Stable Version](https://poser.pugx.org/skeeks/yii2-multi-language/v/stable.png)](https://packagist.org/packages/skeeks/yii2-multi-language)
[![Total Downloads](https://poser.pugx.org/skeeks/yii2-multi-language/downloads.png)](https://packagist.org/packages/skeeks/yii2-multi-language)


Installation
------------

```sh
$ composer require skeeks/yii2-multi-language "^0.0.1"
```

Or add this to your `composer.json` file:

```json
{
    "require": {
        "skeeks/yii2-multi-language": "^0.0.1"
    }
}
```

Use config your application
-----

```php

"bootstrap" => ["multiLanguage"],

"components" => [

    "request" => [
        "class" => \skeeks\yii2\multiLanguage\MultiLangRequest::class
    ],
    
    "urlManager" => [
        "class" => \skeeks\yii2\multiLanguage\MultiLangUrlManager::class,
        'enablePrettyUrl' => true,
        'showScriptName' => false,
    ],
    
    "multiLanguage" => [
        "class" => \skeeks\yii2\multiLanguage\MultiLangComponent::class,
        'langs' => ['ru', 'en'],
        'default_lang' => 'ru',
        'lang_param_name' => 'lang',
    ]
    
]
```

Example
-----
```php

Url::to(['/module/controller/action', 'id' => 20, 'lang' => 'en'])
// /en/module/controller/action?id=20

```
Screenshot
----------


Video
-----


Links
----------
* [Github](https://github.com/skeeks-semenov/yii2-multi-language)
* [Changelog](https://github.com/skeeks-semenov/yii2-multi-language/blob/master/CHANGELOG.md)
* [Issues](https://github.com/skeeks-semenov/yii2-multi-language/issues)
* [Packagist](https://packagist.org/packages/skeeks/yii2-multi-language)

* [SkeekS blog post](https://skeeks.com/blog/programming/397-kak-preobrazovat-neaktivnye-ssylki-v-tekste-v-aktivnye-klikabelnye)
* [SkeekS marketplace](https://cms.skeeks.com/marketplace/components/tools/other/396-preobrazovanie-neaktivnyh-ssylok-v-tekste)

___

> [![skeeks!](https://skeeks.com/img/logo/logo-no-title-80px.png)](https://skeeks.com)  
<i>SkeekS CMS (Yii2) — quickly, easily and effectively!</i>  
[skeeks.com](https://skeeks.com) | [cms.skeeks.com](https://cms.skeeks.com)

