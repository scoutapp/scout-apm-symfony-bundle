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
        $treeBuilder = new TreeBuilder();

        /**
         * @psalm-suppress PossiblyUndefinedMethod analysis failures are down to annotations upstream
         * @psalm-suppress DeprecatedMethod TreeBuilder changed between SF4-5, method is deprecated now
         */
        $children = $treeBuilder->root('scout_apm')
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
