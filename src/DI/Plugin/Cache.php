<?php

declare(strict_types=1);

namespace FreezyBee\Httplug\DI\Plugin;

use Http\Client\Common\Plugin\CachePlugin;
use Nette\DI\ContainerBuilder;
use Nette\DI\ServiceDefinition;
use Nette\StaticClass;

/**
 * @author Jakub Janata <jakubjanata@gmail.com>
 */
class Cache implements IPluginServiceDefinitonCreator
{
    use StaticClass;

    /**
     * @param ContainerBuilder $containerBuilder
     * @param string $extensionName
     * @param string $clientName
     * @param array[] $pluginConfig
     * @return ServiceDefinition
     */
    public static function createPluginServiceDefinition(
        ContainerBuilder $containerBuilder,
        string $extensionName,
        string $clientName,
        array $pluginConfig
    ): ServiceDefinition {

        $args = [];

        $pool = $pluginConfig['pool'] ?? null;
        if ($pool !== null) {
            $args['pool'] = $pool;
        }

        $streamFactory = $pluginConfig['streamFactory'] ?? null;
        if ($streamFactory !== null) {
            $args['streamFactory'] = $streamFactory;
        }

        $config = [];
        foreach ($pluginConfig['config'] as $key => $value) {
            $config[strtolower(preg_replace('#(.)(?=[A-Z])#', '$1_', $key) ?: '')] = $value;
        }
        $args['config'] = $config;

        return $containerBuilder->addDefinition("$extensionName.client.$clientName.plugin.cache")
            ->setType(CachePlugin::class)
            ->setArguments($args)
            ->setAutowired(false);
    }
}
