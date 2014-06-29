<?php

namespace KNone\TranslateBundle\Provider;

use KNone\TranslateBundle\Provider\ProviderInterface;

/**
 * Interface ProviderFactoryInterface
 * @package KNone\TranslateBundle\Provider
 * @author Krasnoyartsev Nikita <i@knone.ru>
 */
interface ProviderFactoryInterface
{
    /**
     * @return ProviderInterface
     */
    public function getTranslator();
}