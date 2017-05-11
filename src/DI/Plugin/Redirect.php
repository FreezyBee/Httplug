<?php
declare(strict_types=1);

namespace FreezyBee\Httplug\DI\Plugin;

use Http\Client\Common\Plugin\RedirectPlugin;
use Nette\DI\ContainerBuilder;
use Nette\DI\ServiceDefinition;
use Nette\StaticClass;

/**
 * @author Jakub Janata <jakubjanata@gmail.com>
 */
class Redirect implements IPluginServiceDefinitonCreator
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

        $config = [];
        foreach ($pluginConfig as $key => $value) {
            $config[strtolower(preg_replace('#(.)(?=[A-Z])#', '$1_', $key))] = $value;
        }

        return $containerBuilder->addDefinition("$extensionName.client.$clientName.plugin.redirect")
            ->setClass(RedirectPlugin::class)
            ->setArguments([$config])
            ->setAutowired(false);
    }
}
