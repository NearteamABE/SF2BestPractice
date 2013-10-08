<?php

namespace Nearteam\CoreBundle\DependencyInjection;

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
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder()
    {
        // TODO : décrire la structure d'une entrée memcache
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder
                ->root('nearteam_core')
                ->children()
                ->variableNode('memcache')
                ->end()
                ->end();

        return $treeBuilder;
    }

}
