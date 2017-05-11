<?php
declare(strict_types=1);

namespace FreezyBee\Httplug\DI\Plugin;

use Http\Client\Common\Plugin\RetryPlugin;
use Nette\DI\ContainerBuilder;
use Nette\DI\ServiceDefinition;
use Nette\StaticClass;

/**
 * @author Jakub Janata <jakubjanata@gmail.com>
 */
class Retry implements IPluginServiceDefinitonCreator
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

        return $containerBuilder->addDefinition("$extensionName.client.$clientName.plugin.retry")
            ->setClass(RetryPlugin::class)
            ->setArguments([$pluginConfig])
            ->setAutowired(false);
    }
}
