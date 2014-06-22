<?php

namespace KNone\TranslateBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * Class KNoneTranslateExtension
 * @package KNone\TranslateBundle\DependencyInjection
 * @author Krasnoyartsev Nikita <i@knone.ru>
 */
class KNoneTranslateExtension extends Extension
{
    /**
     * {@inheritDoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yml');

        $translator = $container->findDefinition('k_none_translate.provider_factory');
        $translator->replaceArgument(1, $config);
    }
}

