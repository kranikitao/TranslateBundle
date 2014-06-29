<?php

namespace KNone\TranslateBundle\Provider;

use KNone\TranslateBundle\Provider\ProviderInterface;
use GuzzleHttp\Client;
use Symfony\Component\Config\Definition\Exception\InvalidConfigurationException;

/**
 * Class ProviderFactory
 * @package KNone\TranslateBundle\Provider
 * @author Krasnoyartsev Nikita <i@knone.ru>
 */
class ProviderFactory
{
    /**
     * @var Client
     */
    private $client;

    /**
     * @var array
     */
    private $config;

    /**
     * @var array
     */
    private $requiredKey = [
        'yandex_api' => true,
        'google_web' => false
    ];

    /**
     * @var ProviderInterface
     */
    protected $instance = null;

    /**
     * @param Client $client
     * @param array $config
     */
    public function __construct(Client $client, array $config)
    {
        $this->client = $client;
        $this->config = $config;
    }

    /**
     * @return ProviderInterface
     */
    public function getTranslator()
    {
        if (!$this->instance) {
            $class = $this->getClass();
            $key = $this->getKey();
            if ($key) {
                $this->instance = new $class($this->client, $key);
            } else {
                $this->instance = new $class($this->client);
            }
        }

        return $this->instance;
    }

    /**
     * @return string
     */
    protected function getClass()
    {
        return $this->config['providers'][$this->config['default_provider']]['class'];
    }

    /**
     * @return bool|string
     * @throws InvalidConfigurationException
     */
    protected function getKey()
    {
        $defaultProvider = $this->config['default_provider'];

        if ($this->requiredKey[$defaultProvider]) {
            if (!isset($this->config['providers'][$defaultProvider]['key'])) {
                throw new InvalidConfigurationException(
                    'The child node "key" at path "k_none_translate.providers.' . $this->config['default_provider'] . '" must be configured.'
                );
            }
            return $this->config['providers'][$defaultProvider]['key'];
        }

        return false;
    }
}