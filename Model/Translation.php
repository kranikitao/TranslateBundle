<?php

namespace KNone\TranslateBundle\Model;

/**
 * Class Translation
 * @package KNone\TranslateBundle\Model
 * @author Krasnoyartsev Nikita <i@knone.ru>
 */
class Translation
{
    /**
     * @var string
     */
    private $source;

    /**
     * @var string
     */
    private $result;

    /**
     * @var string
     */
    private $sourceLanguage;

    /**
     * @var string
     */
    private $resultLanguage;

    /**
     * @param string $source
     * @param string $result
     * @param string $sourceLanguage
     * @param string $resultLanguage
     */
    public function __construct($source, $result, $sourceLanguage, $resultLanguage)
    {
        $this->source = $source;
        $this->result = $result;
        $this->sourceLanguage = $sourceLanguage;
        $this->resultLanguage = $resultLanguage;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->getResult();
    }

    /**
     * @return string
     */
    public function getResult()
    {
        return $this->result;
    }

    /**
     *
     */
    public function getSource()
    {
        return $this->source;
    }

    /**
     * @return string
     */
    public function getSourceLanguage()
    {
        return $this->sourceLanguage;
    }

    /**
     * @return string
     */
    public function getResultLanguage()
    {
        return $this->resultLanguage;
    }
}

