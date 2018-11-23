<?php
declare(strict_types=1);

namespace FreezyBee\Httplug\DI\Plugin;

use Http\Client\Common\Plugin\AuthenticationPlugin;
use Http\Message\Authentication\BasicAuth;
use Http\Message\Authentication\Bearer;
use Http\Message\Authentication\Wsse;
use InvalidArgumentException;
use Nette\DI\ContainerBuilder;
use Nette\DI\ServiceDefinition;
use Nette\StaticClass;

/**
 * @author Jakub Janata <jakubjanata@gmail.com>
 */
class Authentication implements IPluginServiceDefinitonCreator
{
    use StaticClass;

    /**
     * @param ContainerBuilder $containerBuilder
     * @param string $extensionName
     * @param string $clientName
     * @param array $pluginConfig
     * @return ServiceDefinition
     * @throws InvalidArgumentException
     */
    public static function createPluginServiceDefinition(
        ContainerBuilder $containerBuilder,
        string $extensionName,
        string $clientName,
        array $pluginConfig
    ): ServiceDefinition {
        $type = $pluginConfig['type'] ?? null;

        if ($type === null) {
            throw new InvalidArgumentException("Hey! client.$clientName.plugin.authentication need type");
        }

        switch ($type) {
            case 'bearer':
                $authServiceDef = $containerBuilder
                    ->addDefinition("$extensionName.client.$clientName.plugin.authentication.bearer")
                    ->setType(Bearer::class)
                    ->setArguments([$pluginConfig['token']])
                    ->setAutowired(false);
                break;
            case 'basic':
                $authServiceDef = $containerBuilder
                    ->addDefinition("$extensionName.client.$clientName.plugin.authentication.basic")
                    ->setType(BasicAuth::class)
                    ->setArguments([$pluginConfig['username'], $pluginConfig['password']])
                    ->setAutowired(false);
                break;
            case 'wsse':
                $authServiceDef = $containerBuilder
                    ->addDefinition("$extensionName.client.$clientName.plugin.authentication.wsse")
                    ->setType(Wsse::class)
                    ->setArguments([$pluginConfig['username'], $pluginConfig['password']])
                    ->setAutowired(false);
                break;
            case 'service':
                $authServiceDef = $pluginConfig['service'];
                break;
            default:
                throw new InvalidArgumentException("Unknown authentication type: $type");
        }

        return $containerBuilder->addDefinition("$extensionName.client.$clientName.plugin.authentication")
            ->setType(AuthenticationPlugin::class)
            ->setArguments([$authServiceDef])
            ->setAutowired(false);
    }
}
