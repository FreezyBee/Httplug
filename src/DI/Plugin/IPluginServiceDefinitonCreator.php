<?php

declare(strict_types=1);

namespace FreezyBee\Httplug\DI\Plugin;

use Nette\DI\ContainerBuilder;
use Nette\DI\ServiceDefinition;

/**
 * @author Jakub Janata <jakubjanata@gmail.com>
 */
interface IPluginServiceDefinitonCreator
{
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
    ): ServiceDefinition;
}
