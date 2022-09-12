<?php

declare(strict_types=1);

namespace FreezyBee\Httplug\DI\Plugin;

use Http\Client\Common\Plugin\CookiePlugin;
use Http\Message\CookieJar;
use Nette\DI\ContainerBuilder;
use Nette\DI\Definitions\Definition;
use Nette\StaticClass;

/**
 * @author Jakub Janata <jakubjanata@gmail.com>
 */
class Cookie implements IPluginServiceDefinitonCreator
{
    use StaticClass;

    public static function createPluginServiceDefinition(
        ContainerBuilder $containerBuilder,
        string $extensionName,
        string $clientName,
        array $pluginConfig
    ): Definition {

        $cookieJar = $pluginConfig['cookieJar'] ?? new CookieJar();

        return $containerBuilder->addDefinition("$extensionName.client.$clientName.plugin.cookie")
            ->setType(CookiePlugin::class)
            ->setArguments([$cookieJar])
            ->setAutowired(false);
    }
}
