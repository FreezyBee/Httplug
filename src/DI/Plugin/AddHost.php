<?php

declare(strict_types=1);

namespace FreezyBee\Httplug\DI\Plugin;

use Http\Client\Common\Plugin\AddHostPlugin;
use Nette\DI\ContainerBuilder;
use Nette\DI\Definitions\Definition;
use Nette\StaticClass;
use Psr\Http\Message\UriInterface;

/**
 * @author Jakub Janata <jakubjanata@gmail.com>
 */
class AddHost implements IPluginServiceDefinitonCreator
{
    use StaticClass;

    public static function createPluginServiceDefinition(
        ContainerBuilder $containerBuilder,
        string $extensionName,
        string $clientName,
        array $pluginConfig
    ): Definition {

        $uriServiceDef = $containerBuilder
            ->addDefinition("$extensionName.client.$clientName.plugin.addHost.uri")
            ->setType(UriInterface::class)
            ->setAutowired(false)
            ->setFactory(["@$extensionName.uriFactory", 'createUri'])
            ->setArguments([$pluginConfig['host']]);

        return $containerBuilder->addDefinition("$extensionName.client.$clientName.plugin.addHost")
            ->setType(AddHostPlugin::class)
            ->setArguments([$uriServiceDef, ['replace' => $pluginConfig['replace'] ?? false]])
            ->setAutowired(false);
    }
}
