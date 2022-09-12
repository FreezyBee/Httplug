<?php

declare(strict_types=1);

namespace FreezyBee\Httplug\DI\Plugin;

use Nette\DI\ContainerBuilder;
use Nette\DI\Definitions\Definition;

/**
 * @author Jakub Janata <jakubjanata@gmail.com>
 */
interface IPluginServiceDefinitonCreator
{
    /**
     * @param array<mixed> $pluginConfig
     */
    public static function createPluginServiceDefinition(
        ContainerBuilder $containerBuilder,
        string $extensionName,
        string $clientName,
        array $pluginConfig
    ): Definition;
}
