<?php
declare(strict_types=1);

namespace FreezyBee\Httplug\Tests\Integration;

require __DIR__ . '/../bootstrap.php';

use FreezyBee\Httplug\Tracy\PluginClientDecorator;
use Http\Client\Common\PluginClient;
use Nette\Configurator;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\StreamFactoryInterface;
use Psr\Http\Message\UriFactoryInterface;
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
        Assert::true($clientBase instanceof ClientInterface);

        $requestFactory = $container->getService('httplug.requestFactory');
        Assert::true($requestFactory instanceof RequestFactoryInterface);

        $uriFactory = $container->getService('httplug.uriFactory');
        Assert::true($uriFactory instanceof UriFactoryInterface);

        $streamFactory = $container->getService('httplug.streamFactory');
        Assert::true($streamFactory instanceof StreamFactoryInterface);

        $request = $requestFactory->createRequest('GET', 'https://ifire.cz');
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

        $requestFactory = $container->getService('httplug.requestFactory');
        Assert::true($requestFactory instanceof RequestFactoryInterface);

        $request = $requestFactory->createRequest('GET', 'https://ifire.cz');
        $response = $client->sendRequest($request);
        Assert::same(200, $response->getStatusCode());
    }
}

(new ServiceInstantiationTest)->run();
