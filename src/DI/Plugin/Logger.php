<?php
declare(strict_types=1);

namespace FreezyBee\Httplug\DI\Plugin;

use Http\Client\Common\Plugin\LoggerPlugin;
use Nette\DI\ContainerBuilder;
use Nette\DI\ServiceDefinition;
use Nette\StaticClass;

/**
 * @author Jakub Janata <jakubjanata@gmail.com>
 */
class Logger implements IPluginServiceDefinitonCreator
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

        $args = ['formatter' => $pluginConfig['formatter'] ?? null];

        $logger = $pluginConfig['logger'] ?? null;
        if ($logger !== null) {
            $args['logger'] = $logger;
        }

        return $containerBuilder->addDefinition("$extensionName.client.$clientName.plugin.logger")
            ->setType(LoggerPlugin::class)
            ->setArguments($args)
            ->setAutowired(false);
    }
}
