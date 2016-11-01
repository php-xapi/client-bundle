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

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Reference;

/**
 * @author Christian Flothmann <christian.flothmann@xabbuh.de>
 */
class XApiClientExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        foreach ($config['clients'] as $name => $clientConfig) {
            $factory = new Definition('Xabbuh\XApi\Client\XApiClientBuilder');
            $factory->addMethodCall('setBaseUrl', array($clientConfig['base_url']));

            if (isset($clientConfig['basic_auth'])) {
                $factory->addMethodCall('setAuth', array($clientConfig['basic_auth']['username'], $clientConfig['basic_auth']['password']));
            }

            if (isset($clientConfig['oauth'])) {
                $factory->addMethodCall('setOAuthCredentials', array(
                    $clientConfig['oauth']['consumer_key'],
                    $clientConfig['oauth']['consumer_secret'],
                    $clientConfig['oauth']['access_token'],
                    $clientConfig['oauth']['token_secret'],
                ));
            }

            $container->setDefinition('xapi_client.factory.'.$name, $factory);

            $client = new Definition('Xabbuh\XApi\Client\XApiClientInterface');
            $client->setFactory(array(new Reference('xapi_client.factory.'.$name), 'build'));
            $container->setDefinition('xapi_client.client.'.$name, $client);
        }
    }

    public function getAlias()
    {
        return 'xapi_client';
    }
}
