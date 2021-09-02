<?php
declare(strict_types=1);

namespace FreezyBee\Httplug\Tests\Integration;

require __DIR__ . '/../bootstrap.php';

use FreezyBee\Httplug\Tracy\PluginClientDecorator;
use Http\Client\Common\PluginClient;
use Http\Client\HttpClient;
use Http\Message\MessageFactory;
use Http\Message\StreamFactory;
use Http\Message\UriFactory;
use Nette\Configurator;
use Tester\Assert;
use Tester\TestCase;

/**
 * @author Jakub Janata <jakubjanata@gmail.com>
 */
class ServiceInstantiationTest extends TestCase
{
    /**
     *
     */
    public function testHttpClient(): void
    {
        $configurator = new Configurator;
        $configurator->setDebugMode(false);
        $configurator->setTempDirectory(__DIR__ . '/../tmp');
        $configurator->addConfig(__DIR__ . '/../config.neon');
        $container = $configurator->createContainer();

        /** @var HttpClient $client */
        $client = $container->getService('httplug.client.test');
        Assert::true($client instanceof PluginClient);

        $clientBase = $container->getService('httplug.client');
        Assert::true($clientBase instanceof HttpClient);

        $messageFactory = $container->getService('httplug.messageFactory');
        Assert::true($messageFactory instanceof MessageFactory);

        $uriFactory = $container->getService('httplug.uriFactory');
        Assert::true($uriFactory instanceof UriFactory);

        $streamFactory = $container->getService('httplug.streamFactory');
        Assert::true($streamFactory instanceof StreamFactory);

        $request = $messageFactory->createRequest('GET', 'https://ifire.cz');
        $response = $client->sendRequest($request);
        Assert::same(200, $response->getStatusCode());
    }

    /**
     *
     */
    public function testHttpClientTracy(): void
    {
        $configurator = new Configurator;
        $configurator->setDebugMode(true);
        $configurator->setTempDirectory(__DIR__ . '/../tmp');
        $configurator->addConfig(__DIR__ . '/../config.neon');
        $container = $configurator->createContainer();

        /** @var HttpClient $client */
        $client = $container->getService('httplug.client.test');
        Assert::true($client instanceof PluginClientDecorator);

        /** @var MessageFactory $messageFactory */
        $messageFactory = $container->getService('httplug.messageFactory');
        Assert::true($messageFactory instanceof MessageFactory);

        $request = $messageFactory->createRequest('GET', 'https://ifire.cz');
        $response = $client->sendRequest($request);
        Assert::same(200, $response->getStatusCode());
    }
}

(new ServiceInstantiationTest)->run();
