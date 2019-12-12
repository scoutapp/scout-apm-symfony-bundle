<?php

declare(strict_types=1);

namespace Scoutapm\ScoutApmBundle\DependencyInjection;

use Scoutapm\ScoutApmAgent;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;

final class ScoutApmExtension extends Extension
{
    /**
     * @inheritDoc
     * @throws \Exception
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = $this->getConfiguration($configs, $container);
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new XmlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
        $loader->load('scoutapm.xml');

        $definition = $container->getDefinition(ScoutApmAgent::class);
        $definition->replaceArgument('$agentConfiguration', $config['scoutapm']);
    }
}
