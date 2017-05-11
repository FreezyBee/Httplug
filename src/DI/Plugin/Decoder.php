<?php
declare(strict_types=1);

namespace FreezyBee\Httplug\DI\Plugin;

use Http\Client\Common\Plugin\DecoderPlugin;
use Nette\DI\ContainerBuilder;
use Nette\DI\ServiceDefinition;
use Nette\StaticClass;

/**
 * @author Jakub Janata <jakubjanata@gmail.com>
 */
class Decoder implements IPluginServiceDefinitonCreator
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

        return $containerBuilder->addDefinition("$extensionName.client.$clientName.plugin.decoder")
            ->setClass(DecoderPlugin::class)
            ->setArguments([['use_content_encoding' => $pluginConfig['useContentEncoding'] ?? true]])
            ->setAutowired(false);
    }
}
