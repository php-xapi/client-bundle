<?php

/*
 * This file is part of the xAPI package.
 *
 * (c) Christian Flothmann <christian.flothmann@xabbuh.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace XApi\ClientBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * @author Christian Flothmann <christian.flothmann@xabbuh.de>
 */
class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();

        $treeBuilder
            ->root('xapi_client')
                ->children()
                    ->arrayNode('clients')
                        ->prototype('array')
                            ->children()
                                ->scalarNode('base_url')->isRequired()->end()
                                ->arrayNode('basic_auth')
                                    ->children()
                                        ->scalarNode('username')->isRequired()->end()
                                        ->scalarNode('password')->isRequired()->end()
                                    ->end()
                                ->end()
                                ->arrayNode('oauth')
                                    ->children()
                                        ->scalarNode('consumer_key')->isRequired()->end()
                                        ->scalarNode('consumer_secret')->isRequired()->end()
                                        ->scalarNode('access_token')->isRequired()->end()
                                        ->scalarNode('token_secret')->isRequired()->end()
                                    ->end()
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
