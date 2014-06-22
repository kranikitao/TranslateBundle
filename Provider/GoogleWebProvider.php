<?php

namespace KNone\TranslateBundle\Provider;

use KNone\TranslateBundle\Model\Translation;
use KNone\TranslateBundle\Exception\TranslateException;
use GuzzleHttp\Client;
use GuzzleHttp\Message\ResponseInterface;

/**
 * Class GoogleWebProvider
 * @package KNone\TranslateBundle\Provider
 * @author Krasnoyartsev Nikita <i@knone.ru>
 */
class GoogleWebProvider implements ProviderInterface
{
    /**
     * @var Client
     */
    protected $client;

    /**
     * @var string
     */
    protected $urlTemplate = 'https://translate.google.ru/translate_a/single?client=t&sl=%s&tl=%s&hl=ru&dt=bd&dt=ex&dt=ld&dt=md&dt=qc&dt=rw&dt=rm&dt=ss&dt=t&ie=UTF-8&oe=UTF-8&oc=1&otf=2&ssel=5&tsel=5&q=%s';

    /**
     * @param Client $client
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * @param string $text
     * @param string $sourceLanguage
     * @param string $resultLanguage
     * @return Translation
     */
    public function translate($text, $sourceLanguage, $resultLanguage)
    {
        $url = sprintf($this->urlTemplate, $sourceLanguage, $resultLanguage, rawurlencode($text));
        $data = $this->execute($url);
        $translation = new Translation($text, $this->composeTranslationResult($data), $data[1], $resultLanguage);

        return $translation;
    }

    /**
     * @param $url
     * @return array
     * @throws TranslateException
     */
    protected function execute($url)
    {
        $resource = $this->client->get($url);
        if ($resource->getStatusCode() > 200) {
            throw new TranslateException();
        }
        $rawData = preg_replace('/,+/', ',', (string)$resource->getBody());

        return json_decode($rawData);
    }

    /**
     * @param array $data
     * @return string
     */
    protected function composeTranslationResult(array $data)
    {
        $result = '';
        foreach($data[0] as $results) {
            $result .= $results[0];
        }

        return $result;
    }
}