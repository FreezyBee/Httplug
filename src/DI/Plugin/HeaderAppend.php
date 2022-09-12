<?php

declare(strict_types=1);

namespace FreezyBee\Httplug\DI\Plugin;

use Http\Client\Common\Plugin\HeaderAppendPlugin;
use Nette\DI\ContainerBuilder;
use Nette\DI\Definitions\Definition;
use Nette\StaticClass;

/**
 * @author Jakub Janata <jakubjanata@gmail.com>
 */
class HeaderAppend implements IPluginServiceDefinitonCreator
{
    use StaticClass;

    public static function createPluginServiceDefinition(
        ContainerBuilder $containerBuilder,
        string $extensionName,
        string $clientName,
        array $pluginConfig
    ): Definition {

        return $containerBuilder
            ->addDefinition("$extensionName.client.$clientName.plugin.headerAppend")
            ->setType(HeaderAppendPlugin::class)
            ->setArguments([$pluginConfig['headers']])
            ->setAutowired(false);
    }
}
