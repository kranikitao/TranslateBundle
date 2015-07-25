KNoneTranslateBundle
============
This bundle for Symfony2 applications, which translate some text in your application using different translator-services

[![Latest Stable Version](https://poser.pugx.org/knone/translate-bundle/v/stable.svg)](https://packagist.org/packages/knone/translate-bundle) [![Total Downloads](https://poser.pugx.org/knone/translate-bundle/downloads.svg)](https://packagist.org/packages/knone/translate-bundle) [![License](https://poser.pugx.org/knone/translate-bundle/license.svg)](https://packagist.org/packages/knone/translate-bundle)

[![Build Status](https://travis-ci.org/KNonen/TranslateBundle.svg)](https://travis-ci.org/KNonen/TranslateBundle) [![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/KNone/TranslateBundle/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/KNone/TranslateBundle/?branch=master)

Installation
-----------
Download using composer:

``` bash
php composer.phar require knone/translate-bundle '1.0.*'
```

Enable the bundle in the kernel:

``` php
<?php
// app/AppKernel.php

public function registerBundles()
{
    $bundles = array(
        // ...
        new KNone\TranslateBundle\KNoneTranslateBundle(),
    );
}
```

Configure the KNoneTranslateBundle
--------
KNoneTranslateBundle have two translator-providers:

1. google_web (use http://translate.google.com)
2. yandex_api (http://api.yandex.com/translate/)

You need to set default provider in config.yml:

``` yml
//app/config/config.yml
k_none_translate:
    default_provider: google_web
```

If you want to use Yandex Api you need set api key ([get api key](http://api.yandex.com/key/form.xml?service=trnsl)):

``` yml
//app/config/config.yml
k_none_translate:
    default_provider: yandex_api
    providers:
        yandex_api:
            key: <api_key>
```

Using the KNoneTranslateBundle
----------

You just can use service k_none_translate.translator.
Example:

``` php
<?php
...
// Some action in controller
public function someAction()
{
    /** @var KNone\TranslateBundle\Provider\ProviderInterface $translator */
    $translator = $this->get('k_none_translate.translator');
    $translation = $translator->translate('hello world', 'en', 'fr');
    // you can set 'auto' as source language and translator will detect it
    //$translation = $translator->translate('hello world', 'auto', 'fr');

    $result = (string)$translation; // $result contains 'bonjour tout le monde'
    $result = $translation->getResult(); // $result contains 'bonjour tout le monde'
    $source = $translation->getSource(); // $source contains 'hello world'
    $sourceLanguage = $translation->getSourceLanguage() // $sourceLanguage contains 'en'
    $resultLanguage = $translation->getResultLanguage() // $resultLanguage contains 'fr'
}
```
