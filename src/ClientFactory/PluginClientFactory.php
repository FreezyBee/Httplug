<?php

declare(strict_types=1);

namespace FreezyBee\Httplug\ClientFactory;

use FreezyBee\Httplug\Tracy\PluginClientDecorator;
use Http\Client\Common\Plugin;
use Http\Client\Common\PluginClient;

/**
 * This factory creates a PluginClient.
 *
 * @author Tobias Nyholm <tobias.nyholm@gmail.com>
 */
class PluginClientFactory
{
    /**
     * @param Plugin[] $plugins
     * @param array<mixed> $config config to the client factory
     * @param array<mixed> $pluginClientOptions config forwarded to the PluginClient
     * @return PluginClientDecorator|PluginClient
     */
    public static function createPluginClient(
        array $plugins,
        ClientFactory $factory,
        array $config,
        array $pluginClientOptions = [],
        bool $debugMode = false
    ) {
        $client = $factory->createClient($config);

        return $debugMode ?
            new PluginClientDecorator($client, $plugins, $pluginClientOptions) :
            new PluginClient($client, $plugins, $pluginClientOptions);
    }
}
