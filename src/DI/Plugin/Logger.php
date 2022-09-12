<?php

declare(strict_types=1);

namespace FreezyBee\Httplug\DI\Plugin;

use Http\Client\Common\Plugin\LoggerPlugin;
use Nette\DI\ContainerBuilder;
use Nette\DI\Definitions\Definition;
use Nette\StaticClass;

/**
 * @author Jakub Janata <jakubjanata@gmail.com>
 */
class Logger implements IPluginServiceDefinitonCreator
{
    use StaticClass;

    public static function createPluginServiceDefinition(
        ContainerBuilder $containerBuilder,
        string $extensionName,
        string $clientName,
        array $pluginConfig
    ): Definition {

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
