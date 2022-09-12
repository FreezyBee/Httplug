<?php

declare(strict_types=1);

namespace FreezyBee\Httplug\DI\Plugin;

use Http\Client\Common\Plugin\DecoderPlugin;
use Nette\DI\ContainerBuilder;
use Nette\DI\Definitions\Definition;
use Nette\StaticClass;

/**
 * @author Jakub Janata <jakubjanata@gmail.com>
 */
class Decoder implements IPluginServiceDefinitonCreator
{
    use StaticClass;

    public static function createPluginServiceDefinition(
        ContainerBuilder $containerBuilder,
        string $extensionName,
        string $clientName,
        array $pluginConfig
    ): Definition {

        return $containerBuilder->addDefinition("$extensionName.client.$clientName.plugin.decoder")
            ->setType(DecoderPlugin::class)
            ->setArguments([['use_content_encoding' => $pluginConfig['useContentEncoding'] ?? true]])
            ->setAutowired(false);
    }
}
