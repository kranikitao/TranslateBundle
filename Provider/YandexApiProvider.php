<?php

namespace KNone\TranslateBundle\Provider;

use KNone\TranslateBundle\Entity\Translation;
use KNone\TranslateBundle\Exception\TranslateException;
use GuzzleHttp\Client;

/**
 * Class YandexApiProvider
 * @package KNone\TranslateBundle\Provider
 * @author Krasnoyartsev Nikita <i@knone.ru>
 */
class YandexApiProvider implements ProviderInterface
{
    /**
     * @var Client
     */
    protected $client;

    /**
     * @var string
     */
    protected $key;

    /**
     * @var string
     */
    protected $url = 'https://translate.yandex.net/api/v1.5/tr.json/translate';

    /**
     * @param Client $client
     * @param string $key
     */
    public function __construct(Client $client, $key)
    {
        $this->client = $client;
        $this->key = $key;
    }

    /**
     * @param string $text
     * @param string $sourceLanguage
     * @param string $resultLanguage
     * @return Translation
     */
    public function translate($text, $sourceLanguage, $resultLanguage)
    {
        $url = $this->composeUrl($text, $sourceLanguage, $resultLanguage);
        $data = $this->execute($url);
        $language = explode('-', $data['lang']);
        $translation = new Translation($text, implode(' ', (array)$data['text']), $language[0], $resultLanguage);

        return $translation;
    }

    /**
     * @param string $text
     * @param string $sourceLanguage
     * @param string $resultLanguage
     * @return string
     */
    protected function composeUrl($text, $sourceLanguage, $resultLanguage)
    {
        $lang = $sourceLanguage . '-' . $resultLanguage;
        if ($sourceLanguage === 'auto') {
            $lang = $resultLanguage;
        }
        $parameters = [
            'key' => $this->key,
            'text' => $text,
            'lang' => $lang,
            'format' => 'plain',
            'options' => 0
        ];

        return $this->url . '?' . http_build_query($parameters);
    }

    /**
     * @param $url
     * @return mixed
     * @throws \KNone\TranslateBundle\Exception\TranslateException
     */
    protected function execute($url)
    {
        $response = $this->client->get($url);
        $responseCode = $response->getStatusCode();

        if ($responseCode > 200) {
            $result = $response->json();
            throw new TranslateException($response->getReasonPhrase(), $responseCode);
        }

        return $response->json();
    }

}