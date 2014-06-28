<?php

namespace KNone\TranslateBundle\Provider;

use KNone\TranslateBundle\Entity\Translation;

/**
 * Interface ProviderInterface
 * @package KNone\TranslateBundle\Provider
 * @author Krasnoyartsev Nikita <i@knone.ru>
 */
interface ProviderInterface
{
    /**
     * @param $text
     * @param $sourceLanguage
     * @param $resultLanguage
     * @return Translation
     */
    public function translate($text, $sourceLanguage, $resultLanguage);
}