<?php

namespace Symfonian\Indonesia\GammuBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html#cookbook-bundles-extension-config-class}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('symfonian_indonesia_gammu');

        $rootNode
            ->children()
                ->arrayNode('gammu')
                    ->isRequired()
                    ->cannotBeEmpty()
                    ->children()
                        ->scalarNode('smsd_inject_path')->end()
                        ->arrayNode('smsdrc_path')
                            ->prototype('array')
                                ->children()
                                    ->scalarNode('name')->end()
                                    ->scalarNode('path')->end()
                                ->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end()
        ;

        return $treeBuilder;
    }
}