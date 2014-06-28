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
                ->arrayNode('providers')->addDefaultsIfNotSet()
                    ->children()
                        ->arrayNode('google_web')->addDefaultsIfNotSet()
                            ->children()
                                ->scalarNode('class')
                                    ->defaultValue('KNone\TranslateBundle\Provider\GoogleWebProvider')
                                    ->cannotBeOverwritten()
                                ->end()
                            ->end()
                        ->end()
                        ->arrayNode('yandex_api')->addDefaultsIfNotSet()
                            ->children()
                                ->scalarNode('class')
                                    ->defaultValue('KNone\TranslateBundle\Provider\YandexApiProvider')
                                    ->cannotBeOverwritten()
                                ->end()
                                ->scalarNode('key')
                                    ->cannotBeEmpty()
                                    ->isRequired()
                                ->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
                ->enumNode('default_provider')
                    ->values(array('google_web', 'yandex_api'))
                    ->defaultValue('google_web')
                    ->cannotBeEmpty()
                    ->isRequired()
                 ->end()
            ->end();
        return $treeBuilder;
    }
}
