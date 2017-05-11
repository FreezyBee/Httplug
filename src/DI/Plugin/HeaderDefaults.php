<?php
declare(strict_types=1);

namespace FreezyBee\Httplug\DI\Plugin;

use Http\Client\Common\Plugin\HeaderDefaultsPlugin;
use Nette\DI\ContainerBuilder;
use Nette\DI\ServiceDefinition;
use Nette\StaticClass;

/**
 * @author Jakub Janata <jakubjanata@gmail.com>
 */
class HeaderDefaults implements IPluginServiceDefinitonCreator
{
    use StaticClass;

    /**
     * @param ContainerBuilder $containerBuilder
     * @param string $extensionName
     * @param string $clientName
     * @param array $pluginConfig
     * @return ServiceDefinition
     */
    public static function createPluginServiceDefinition(
        ContainerBuilder $containerBuilder,
        string $extensionName,
        string $clientName,
        array $pluginConfig
    ): ServiceDefinition {

        return $containerBuilder
            ->addDefinition("$extensionName.client.$clientName.plugin.headerDefaults")
            ->setClass(HeaderDefaultsPlugin::class)
            ->setArguments([$pluginConfig['headers']])
            ->setAutowired(false);
    }
}
