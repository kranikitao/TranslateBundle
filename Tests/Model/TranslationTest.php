<?php

namespace KNone\TranslateBundle\Test\Model;

use KNone\TranslateBundle\Model\Translation;

class TranslationTest extends \PHPUnit_Framework_TestCase
{
    const SOURCE = 'Hello world';
    const RESULT = 'Привет мир';
    const SOURCE_LANGUAGE = 'en';
    const RESULT_LANGUAGE = 'ru';

    /**
     * @var Translation
     */
    protected $translation;

    protected function setUp()
    {
        $this->translation = new Translation(self::SOURCE, self::RESULT, self::SOURCE_LANGUAGE, self::RESULT_LANGUAGE);
    }

    public function testToString()
    {
        $this->assertEquals((string)$this->translation, self::RESULT);
    }

    public function testGetResult()
    {
        $this->assertEquals($this->translation->getResult(), self::RESULT);
    }

    public function testGetSource()
    {
        $this->assertEquals($this->translation->getSource(), self::SOURCE);
    }

    public function testGetSourceLanguage()
    {
        $this->assertEquals($this->translation->getSourceLanguage(), self::SOURCE_LANGUAGE);
    }

    public function testGetResultLanguage()
    {
        $this->assertEquals($this->translation->getResultLanguage(), self::RESULT_LANGUAGE);
    }


}