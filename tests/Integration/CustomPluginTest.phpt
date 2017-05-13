<?php
declare(strict_types=1);

namespace FreezyBee\Httplug\Tests\Integration;

require __DIR__ . '/../bootstrap.php';

use FreezyBee\Httplug\Tests\Utils\TestPlugin;
use Http\Client\Common\PluginClient;
use Nette\Configurator;
use Tester\Assert;
use Tester\TestCase;

/**
 * @author Jakub Janata <jakubjanata@gmail.com>
 */
class CustomPluginTest extends TestCase
{
    /**
     *
     */
    public function testAddCustomPlugins(): void
    {
        $configurator = new Configurator;
        $configurator->setDebugMode(false);
        $configurator->setTempDirectory(__DIR__ . '/../tmp');
        $configurator->addConfig(__DIR__ . '/../config.neon');
        $container = $configurator->createContainer();

        // by config.neon
        /** @var PluginClient $client */
        $client = $container->getService('httplug.client.test2');

        $pluginsReflection = new \ReflectionProperty($client, 'plugins');
        $pluginsReflection->setAccessible(true);
        $plugins = $pluginsReflection->getValue($client);

        Assert::true($plugins[0] instanceof TestPlugin);
    }
}

(new CustomPluginTest)->run();
