<?php

namespace KNone\TranslateBundle\Test\Provider;

use GuzzleHttp\Client;
use KNone\TranslateBundle\Provider\GoogleWebProvider;
use KNone\TranslateBundle\Provider\YandexApiProvider;
use KNone\TranslateBundle\Provider\ProviderFactory;
use Symfony\Component\Config\Definition\Exception\InvalidConfigurationException;


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
        $factory = new ProviderFactory($this->client, $this->getDefaultConfig());
        $this->assertInstanceOf(
            'KNone\TranslateBundle\Provider\GoogleWebProvider',
            $factory->getTranslator()
        );
    }

    public function testGetTranslator_YandexApiProvider()
    {
        $config = $this->getDefaultConfig();
        $config['default_provider'] = 'yandex_api';
        $config['providers']['yandex_api']['key'] = 'key';

        $factory = new ProviderFactory($this->client, $config);
        $this->assertInstanceOf(
            'KNone\TranslateBundle\Provider\YandexApiProvider',
            $factory->getTranslator()
        );
    }

    /**
     * @expectedException Symfony\Component\Config\Definition\Exception\InvalidConfigurationException
     */
    public function testGetTranslator_YandexApiProvider_KeyException()
    {
        $config = $this->getDefaultConfig();
        $config['default_provider'] = 'yandex_api';

        $factory = new ProviderFactory($this->client, $config);
        $factory->getTranslator();
    }

    /**
     * @return array
     */
    protected function getDefaultConfig()
    {
        return array(
            'default_provider' => 'google_web',
            'providers' => array(
                'yandex_api' => array(
                    'class' => 'KNone\TranslateBundle\Provider\YandexApiProvider'
                ),
                'google_web' => array(
                    'class' => 'KNone\TranslateBundle\Provider\GoogleWebProvider',
                )
            )
        );
    }
}