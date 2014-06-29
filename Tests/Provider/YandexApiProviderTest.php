<?php

namespace KNone\TranslateBundle\Test\Provider;

use GuzzleHttp\Client;
use KNone\TranslateBundle\Provider\YandexApiProvider;
use GuzzleHttp\Message\ResponseInterface;
use KNone\TranslateBundle\Entity\Translation;

class YandexApiProviderTest extends \PHPUnit_Framework_TestCase
{
    const KEY = 'key';
    const SOURCE = 'привет мир';
    const RESULT = "hello world";
    const SOURCE_LANGUAGE = 'ru';
    const RESULT_LANGUAGE = 'en';

    /**
     * @var YandexApiProvider
     */
    protected $translator;

    /**
     * @var ResponseInterface
     */
    protected $response;

    /**
     * @var Client
     */
    protected $client;

    protected function setUp()
    {
        $this->response = \Phake::mock('GuzzleHttp\Message\ResponseInterface');

        $this->client = \Phake::mock('GuzzleHttp\Client');
        \Phake::when($this->client)->get(\Phake::anyParameters())->thenReturn($this->response);

        $this->translator = new YandexApiProvider($this->client, self::KEY);
    }

    public function testTranslate()
    {
        \Phake::when($this->response)->getStatusCode()->thenReturn(200);
        \Phake::when($this->response)->json()->thenReturn($this->getResponseArray());

        $translation = $this->translator->translate(self::SOURCE, self::SOURCE_LANGUAGE, self::RESULT_LANGUAGE);

        $this->assertEquals($this->getTranslation(), $translation);
    }

    /**
     * @expectedException KNone\TranslateBundle\Exception\TranslateException
     */
    public function testTranslateException()
    {
        \Phake::when($this->response)->getStatusCode()->thenReturn(404);

        $this->translator->translate(self::SOURCE, self::SOURCE_LANGUAGE, self::RESULT_LANGUAGE);

    }

    /**
     * @return Translation
     */
    protected function getTranslation()
    {
        return new Translation(self::SOURCE, self::RESULT, self::SOURCE_LANGUAGE, self::RESULT_LANGUAGE);
    }

    protected function getResponseArray()
    {
        return [
            'code' => 200,
            'lang' => self::SOURCE_LANGUAGE . '-' . self::RESULT_LANGUAGE,
            'text' => [self::RESULT]
        ];
    }


}