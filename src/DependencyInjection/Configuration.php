<?php

declare(strict_types=1);

namespace Scoutapm\ScoutApmBundle\DependencyInjection;

use Scoutapm\Config\ConfigKey;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

final class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder() : TreeBuilder
    {
        $treeBuilder = new TreeBuilder('scout_apm');

        /** @psalm-suppress PossiblyUndefinedMethod analysis failures are down to annotations upstream */
        $children = $treeBuilder->getRootNode()
            ->children()
                ->arrayNode('scoutapm')
                    ->children();

        foreach (ConfigKey::allConfigurationKeys() as $configKey) {
            $children = $children->scalarNode($configKey)->defaultNull()->end();
        }

                    $children->end()
                ->end()
            ->end();

        return $treeBuilder;
    }
}
