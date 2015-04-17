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
                ->scalarNode('gammu_path')
                    ->isRequired()
                    ->cannotBeEmpty()
                ->end()
                ->arrayNode('gammurc_path')
                    ->isRequired()
                    ->requiresAtLeastOneElement()
                    ->useAttributeAsKey('name')
                    ->prototype('array')
                        ->children()
                            ->scalarNode('path')->end()
                        ->end()
                    ->end()
                ->end()
                ->scalarNode('smsd_inject_path')
                    ->isRequired()
                    ->cannotBeEmpty()
                ->end()
                ->arrayNode('smsdrc_path')
                    ->isRequired()
                    ->requiresAtLeastOneElement()
                    ->useAttributeAsKey('name')
                    ->prototype('array')
                        ->children()
                            ->scalarNode('path')->end()
                        ->end()
                    ->end()
                ->end()
            ->end()
        ;

        return $treeBuilder;
    }
}