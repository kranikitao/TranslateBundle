<?php

namespace KNone\TranslateBundle\Test\Provider;

use GuzzleHttp\Client;
use KNone\TranslateBundle\Provider\GoogleWebProvider;
use GuzzleHttp\Message\ResponseInterface;
use KNone\TranslateBundle\Model\Translation;

class GoogleWebProviderTest extends \PHPUnit_Framework_TestCase
{
    const RESPONSE_BODY = '[[["hi\n","привет\n"],["world","мир"],["",,,"privet\nmir"]],,"ru",,[["hi",[1],true,false,968,0,1,0],["\n",[2],true,false,0,0,0,0],["world",[5],true,false,995,0,1,1]],[["привет",1,[["hi",968,true,false],["hello",31,true,false],["greetings",0,true,false],["the hi",0,true,false]],[[0,6]],"привет"],["\n",2,,[[0,1]],"\n"],["мир",5,[["world",995,true,false],["peace",4,true,false],["the world",0,true,false],["world of",0,true,false],["the world of",0,true,false]],[[0,3]],"мир"]],,,[["ru"],,[0.80000001]]]';

    const SOURCE = "привет\nмир";
    const RESULT = "hi\nworld";
    const SOURCE_LANGUAGE = 'ru';
    const RESULT_LANGUAGE = 'en';

    /**
     * @var GoogleWebProvider
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

        $this->translator = new GoogleWebProvider($this->client);
    }

    public function testTranslate()
    {
        \Phake::when($this->response)->getStatusCode()->thenReturn(200);
        \Phake::when($this->response)->getBody()->thenReturn(self::RESPONSE_BODY);

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


}