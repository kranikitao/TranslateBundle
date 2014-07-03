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
     * @param string $text
     * @param string $sourceLanguage
     * @param string $resultLanguage
     * @return Translation
     */
    public function translate($text, $sourceLanguage, $resultLanguage);
}
