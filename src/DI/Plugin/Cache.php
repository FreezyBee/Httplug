<?php

declare(strict_types=1);

namespace FreezyBee\Httplug\DI\Plugin;

use Http\Client\Common\Plugin\CachePlugin;
use Nette\DI\ContainerBuilder;
use Nette\DI\Definitions\Definition;
use Nette\StaticClass;
use Nette\Utils\Strings;

/**
 * @author Jakub Janata <jakubjanata@gmail.com>
 */
class Cache implements IPluginServiceDefinitonCreator
{
    use StaticClass;

    public static function createPluginServiceDefinition(
        ContainerBuilder $containerBuilder,
        string $extensionName,
        string $clientName,
        array $pluginConfig
    ): Definition {

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
            $newKey = Strings::replace($key, '#(.)(?=[A-Z])#', '$1_');
            $config[strtolower($newKey)] = $value;
        }
        $args['config'] = $config;

        return $containerBuilder->addDefinition("$extensionName.client.$clientName.plugin.cache")
            ->setType(CachePlugin::class)
            ->setArguments($args)
            ->setAutowired(false);
    }
}
