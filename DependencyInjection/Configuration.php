<?php

namespace SM\MemcacheBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * defines host and port defaults.
 * This is the class that validates and merges configuration from your app/config files
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html#cookbook-bundles-extension-config-class}
 * @author Nicolas Potier <nicolas.potier@acseo-conseil.fr>
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('sm_memcache');
        $rootNode->children()
            //->scalarNode('port')->defaultValue(11211)->end()
            //->scalarNode('host')->defaultValue('localhost')->end()
            ->arrayNode('instances')
//                ->info('Options for \Memcached class. Ignored for \Memcache instance.')
//                ->useAttributeAsKey('name') if enable throws exception, that array is string. Symfony bug?
                ->prototype('array')
                    ->children()
                        ->scalarNode('host')->isRequired()
                          //  ->info('Final option name will be constant \\Memcached::OPT_*OPTION_NAME*')
                        ->end()
                        ->scalarNode('port')->isRequired()
                           // ->info('Final option value will be constant \\Memcached::*OPTION_VALUE*')
                        ->end()
                    ->end()
                ->end()
            ->end()
            ->scalarNode('use_mock')->defaultValue(false)->end()
            ->scalarNode('class')->defaultValue('')->end()
            ->scalarNode('factory')->defaultValue('SM\\MemcacheBundle\\MemcacheFactory')->end()
            ->arrayNode('options')
//                ->info('Options for \Memcached class. Ignored for \Memcache instance.')
//                ->useAttributeAsKey('name') if enable throws exception, that array is string. Symfony bug?
                ->prototype('array')
                    ->children()
                        ->scalarNode('name')->isRequired()
                          //  ->info('Final option name will be constant \\Memcached::OPT_*OPTION_NAME*')
                        ->end()
                        ->scalarNode('value')->isRequired()
                           // ->info('Final option value will be constant \\Memcached::*OPTION_VALUE*')
                        ->end()
                    ->end()
                ->end()
            ->end()
        ->end();

        return $treeBuilder;
    }
}
