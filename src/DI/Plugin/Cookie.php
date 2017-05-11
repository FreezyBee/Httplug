<?php
declare(strict_types=1);

namespace FreezyBee\Httplug\DI\Plugin;

use Http\Client\Common\Plugin\CookiePlugin;
use Http\Message\CookieJar;
use Nette\DI\ContainerBuilder;
use Nette\DI\ServiceDefinition;
use Nette\StaticClass;

/**
 * @author Jakub Janata <jakubjanata@gmail.com>
 */
class Cookie implements IPluginServiceDefinitonCreator
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

        $cookieJar = $pluginConfig['cookieJar'] ?? new CookieJar;

        return $containerBuilder->addDefinition("$extensionName.client.$clientName.plugin.cookie")
            ->setClass(CookiePlugin::class)
            ->setArguments([$cookieJar])
            ->setAutowired(false);
    }
}
