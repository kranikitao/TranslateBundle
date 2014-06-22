<?php

namespace KNone\TranslateBundle\Test\Provider;

use GuzzleHttp\Client;
use KNone\TranslateBundle\Provider\GoogleWebProvider;
use KNone\TranslateBundle\Provider\YandexApiProvider;
use KNone\TranslateBundle\Provider\ProviderFactory;
use KNone\TranslateBundle\Exception\InvalidConfigurationException;


class ProviderFactoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Client
     */
    protected $client;

    protected function setUp()
    {
        $this->client = \Phake::mock('GuzzleHttp\Client');

    }

    public function testGetTranslator_GoogleWebProvider()
    {
        $factory = new ProviderFactory($this->client, array(
            'default_provider' => 'google_web'
        ));
        $this->assertInstanceOf(
            'KNone\TranslateBundle\Provider\GoogleWebProvider',
            $factory->getTranslator()
        );
    }

    public function testGetTranslator_YandexApiProvider()
    {
        $factory = new ProviderFactory($this->client, array(
            'default_provider' => 'yandex_api',
            'yandex_api_key' => 'key'
        ));
        $this->assertInstanceOf(
            'KNone\TranslateBundle\Provider\YandexApiProvider',
            $factory->getTranslator()
        );
    }

    /**
     * @expectedException KNone\TranslateBundle\Exception\InvalidConfigurationException
     */
    public function testGetTranslator_YandexApiProvider_KeyException()
    {
        $factory = new ProviderFactory($this->client, array(
            'default_provider' => 'yandex_api'
        ));
        $factory->getTranslator();
    }
}