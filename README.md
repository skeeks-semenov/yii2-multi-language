Component for multilingual site
================

[<img src="https://cms.skeeks.com/uploads/all/4f/46/71/4f46711c4f5e78d9b0ce187abe88fd04.png" alt="SkeekS blog" width="200"/>](https://cms.skeeks.com/marketplace/components/tools/401-yii2-komponent-dlya-multiyazychnosti-sajta)

[![Latest Stable Version](https://poser.pugx.org/skeeks/yii2-multi-language/v/stable.png)](https://packagist.org/packages/skeeks/yii2-multi-language)
[![Total Downloads](https://poser.pugx.org/skeeks/yii2-multi-language/downloads.png)](https://packagist.org/packages/skeeks/yii2-multi-language)


Installation
------------

```sh
$ composer require skeeks/yii2-multi-language "^1.0.0"
```

Or add this to your `composer.json` file:

```json
{
    "require": {
        "skeeks/yii2-multi-language": "^1.0.0"
    }
}
```

Use config your application
-----

```php

"bootstrap" => ["multiLanguage"],

"language" => "ru", //Your current application language

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
        'default_lang' => 'ru',         //Language to which no language settings are added.
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

[<img src="https://cms.skeeks.com/uploads/all/f5/fa/f6/f5faf6b3be0dd01e0e368c9280d77e88.png" alt="SkeekS blog" width="600"/>](https://cms.skeeks.com/uploads/all/f5/fa/f6/f5faf6b3be0dd01e0e368c9280d77e88.png)

[<img src="https://cms.skeeks.com/uploads/all/0c/1c/f5/0c1cf53c64d3e13ff4abeb4208d4c9ea.png" alt="SkeekS blog" width="600"/>](https://cms.skeeks.com/uploads/all/0c/1c/f5/0c1cf53c64d3e13ff4abeb4208d4c9ea.png)



Video
-----

[<img src="https://cms.skeeks.com/uploads/all/99/a6/ef/99a6ef3ff72cf285ebe3eb3cc9bb40b8.png" alt="Video" width="557"/>](https://youtu.be/txWgAnMTwqs)


Links
----------
* [Github](https://github.com/skeeks-semenov/yii2-multi-language)
* [Changelog](https://github.com/skeeks-semenov/yii2-multi-language/blob/master/CHANGELOG.md)
* [Issues](https://github.com/skeeks-semenov/yii2-multi-language/issues)
* [Packagist](https://packagist.org/packages/skeeks/yii2-multi-language)
* [SkeekS blog post](https://cms.skeeks.com/blog/404-kak-v-yii2-proekte-sdelat-multiyazychnye-url)
* [SkeekS marketplace](https://cms.skeeks.com/marketplace/components/tools/401-yii2-komponent-dlya-multiyazychnosti-sajta)

___

> [![skeeks!](https://skeeks.com/img/logo/logo-no-title-80px.png)](https://skeeks.com)  
<i>SkeekS CMS (Yii2) — quickly, easily and effectively!</i>  
[skeeks.com](https://skeeks.com) | [cms.skeeks.com](https://cms.skeeks.com)

