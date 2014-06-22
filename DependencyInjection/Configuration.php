<?php

namespace KNone\TranslateBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * Class Configuration
 * @package KNone\TranslateBundle\DependencyInjection
 * @author Krasnoyartsev Nikita <i@knone.ru>
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('k_none_translate');
        $rootNode
            ->children()
                ->scalarNode('yandex_api_key')
                ->end()
                ->enumNode('default_provider')
                    ->values(array('google_web', 'yandex_api'))
                    ->defaultValue('google_web')
                 ->end()
            ->end();
        return $treeBuilder;
    }
}
