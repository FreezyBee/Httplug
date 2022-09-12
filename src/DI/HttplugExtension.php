<?php

declare(strict_types=1);

namespace FreezyBee\Httplug\DI;

use FreezyBee\Httplug\ClientFactory\PluginClientFactory;
use FreezyBee\Httplug\DI\Plugin\IPluginServiceDefinitonCreator;
use FreezyBee\Httplug\Tracy\MessagePanel;
use FreezyBee\Httplug\Tracy\PluginClientDecorator;
use Http\Client\Common\PluginClient;
use Http\Client\HttpClient;
use Http\Discovery\HttpClientDiscovery;
use Http\Discovery\MessageFactoryDiscovery;
use Http\Discovery\StreamFactoryDiscovery;
use Http\Discovery\UriFactoryDiscovery;
use Http\Message\MessageFactory;
use Http\Message\StreamFactory;
use Http\Message\UriFactory;
use InvalidArgumentException;
use Nette\DI\CompilerExtension;
use Nette\DI\ContainerBuilder;
use Nette\DI\Definitions\Definition;
use Nette\DI\Definitions\ServiceDefinition;
use Nette\DI\Definitions\Statement;
use Nette\DI\Helpers;

/**
 * @author Jakub Janata <jakubjanata@gmail.com>
 */
class HttplugExtension extends CompilerExtension
{
    private bool $debugMode = false;

    /** @var array<string, mixed> */
    private static array $defaults = [
        # uses discovery if not specified
        'classes' => [
            'client' => null,
            'messageFactory' => null,
            'uriFactory' => null,
            'streamFactory' => null
        ],
        # default settings for clients
        'clientDefaults' => [
            'factory' => null
        ],
        # clients configurations
        'clients' => [],
        # tracy debug
        'tracy' => [
            'debugger' => '%debugMode%',
            'plugins' => []
        ]
    ];

    /** @var array<string, string> */
    private array $classes = [
        'client' => HttpClient::class,
        'messageFactory' => MessageFactory::class,
        'uriFactory' => UriFactory::class,
        'streamFactory' => StreamFactory::class,
    ];

    /** @var array<string, mixed> */
    private array $factoryClasses = [
        'client' => [HttpClientDiscovery::class, 'find'],
        'messageFactory' => [MessageFactoryDiscovery::class, 'find'],
        'uriFactory' => [UriFactoryDiscovery::class, 'find'],
        'streamFactory' => [StreamFactoryDiscovery::class, 'find'],
    ];

    /**
     * {@inheritdoc}
     */
    public function loadConfiguration(): void
    {
        $containerBuilder = $this->getContainerBuilder();

        $this->config = $this->validateConfig(Helpers::expand(self::$defaults, $containerBuilder->parameters));
        $config = $this->config;

        $factories = $this->loadFromFile(__DIR__ . '/factories.neon');
        $this->loadDefinitionsFromConfig($factories);

        $this->debugMode = $config['tracy']['debugger'];

        // register default services
        foreach ($config['classes'] as $service => $class) {
            $def = $containerBuilder->addDefinition($this->prefix($service));

            if ($class !== null) {
                // user defined
                $def->setType($class);
            } else {
                $class = $this->classes[$service];
                // discovery
                $def->setType($class)
                    ->setFactory($this->factoryClasses[$service]);
            }
        }

        // configure clients
        foreach ($config['clients'] as $name => $arguments) {
            $this->configureClient($containerBuilder, $name, $arguments ?? []);
        }

        // register tracy panel
        if ($this->debugMode) {
            /** @var ServiceDefinition $def */
            $def = $containerBuilder->getDefinition('tracy.bar');
            $def->addSetup('addPanel', [new Statement(MessagePanel::class)]);
        }
    }

    /**
     * @param ContainerBuilder $containerBuilder
     * @param string $clientName
     * @param array<mixed> $clientConfig
     */
    private function configureClient(ContainerBuilder $containerBuilder, string $clientName, array $clientConfig): void
    {
        $serviceName = $this->prefix("client.$clientName");

        /** @var mixed[] $config */
        $config = $this->config;
        $factory = $clientConfig['factory'] ?? $config['clientDefaults']['factory'];
        if ($factory === null) {
            throw new InvalidArgumentException('Please specify client factory (or default client factory)');
        }

        $plugins = $clientConfig['plugins'] ?? [];
        $pluginServices = [];

        foreach ($plugins as $pluginName => $pluginConfig) {
            $pluginServices[] = $this->configurePlugin($containerBuilder, $pluginName, $clientName, $pluginConfig);
        }

        $pluginClientOptions = [];

        $containerBuilder
            ->addDefinition($serviceName)
            ->setType($this->debugMode ? PluginClientDecorator::class : PluginClient::class)
            ->setFactory([PluginClientFactory::class, 'createPluginClient'])
            ->setArguments([
                $pluginServices,
                $factory,
                $clientConfig['config'] ?? [],
                $pluginClientOptions,
                $this->debugMode
            ]);
    }

    /**
     * @param array<mixed> $pluginConfig
     */
    private function configurePlugin(
        ContainerBuilder $containerBuilder,
        string $pluginName,
        string $clientName,
        array $pluginConfig
    ): Definition {

        $creator = 'FreezyBee\Httplug\DI\Plugin\\' . ucfirst($pluginName);

        if (class_exists($creator)) {
            /** @var IPluginServiceDefinitonCreator $creator */
            return $creator::createPluginServiceDefinition($containerBuilder, $this->name, $clientName, $pluginConfig);
        }

        // user custom plugin
        $def = $containerBuilder
            ->addDefinition($this->prefix("client.$clientName.plugin.$pluginName"))
            ->setType($pluginConfig['class']);

        if (isset($pluginConfig['arguments'])) {
            $def->setArguments($pluginConfig['arguments']);
        }

        return $def;
    }

    /**
     * {@inheritdoc}
     */
    public function beforeCompile(): void
    {
        $containerBuilder = $this->getContainerBuilder();

        // configure clients from another extensions
        foreach ($this->compiler->getExtensions() as $extension) {
            if ($extension instanceof IClientProvider) {
                foreach ($extension->getClientConfigs() as $name => $arguments) {
                    $this->configureClient($containerBuilder, $name, $arguments ?? []);
                }
            }
        }
    }
}
