<?php

declare(strict_types=1);

namespace FreezyBee\Httplug\DI\Plugin;

use Http\Client\Common\Plugin\HeaderRemovePlugin;
use Nette\DI\ContainerBuilder;
use Nette\DI\Definitions\Definition;
use Nette\StaticClass;

/**
 * @author Jakub Janata <jakubjanata@gmail.com>
 */
class HeaderRemove implements IPluginServiceDefinitonCreator
{
    use StaticClass;

    public static function createPluginServiceDefinition(
        ContainerBuilder $containerBuilder,
        string $extensionName,
        string $clientName,
        array $pluginConfig
    ): Definition {

        return $containerBuilder
            ->addDefinition("$extensionName.client.$clientName.plugin.headerRemove")
            ->setType(HeaderRemovePlugin::class)
            ->setArguments([$pluginConfig['headers']])
            ->setAutowired(false);
    }
}
