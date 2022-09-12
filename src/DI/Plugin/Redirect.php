<?php

declare(strict_types=1);

namespace FreezyBee\Httplug\DI\Plugin;

use Http\Client\Common\Plugin\RedirectPlugin;
use Nette\DI\ContainerBuilder;
use Nette\DI\Definitions\Definition;
use Nette\StaticClass;

/**
 * @author Jakub Janata <jakubjanata@gmail.com>
 */
class Redirect implements IPluginServiceDefinitonCreator
{
    use StaticClass;

    public static function createPluginServiceDefinition(
        ContainerBuilder $containerBuilder,
        string $extensionName,
        string $clientName,
        array $pluginConfig
    ): Definition {

        $config = [];
        foreach ($pluginConfig as $key => $value) {
            $config[strtolower(preg_replace('#(.)(?=[A-Z])#', '$1_', $key) ?: '')] = $value;
        }

        return $containerBuilder->addDefinition("$extensionName.client.$clientName.plugin.redirect")
            ->setType(RedirectPlugin::class)
            ->setArguments([$config])
            ->setAutowired(false);
    }
}
