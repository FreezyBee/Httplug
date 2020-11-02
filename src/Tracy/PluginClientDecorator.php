<?php

declare(strict_types=1);

namespace FreezyBee\Httplug\Tracy;

use Http\Client\Common\PluginClient;
use Http\Client\HttpAsyncClient;
use Http\Client\HttpClient;
use Http\Promise\Promise;
use Nette\SmartObject;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * @author Jakub Janata <jakubjanata@gmail.com>
 */
class PluginClientDecorator implements HttpClient, HttpAsyncClient
{
    use SmartObject;

    /** @var PluginClient */
    private $pluginClient;

    /** @var TracyPlugin */
    private $tracyPlugin;

    /**
     * PluginClientDecorator constructor.
     * @param HttpClient|HttpAsyncClient $client
     * @param array $plugins
     * @param array $options
     */
    public function __construct($client, array $plugins = [], array $options = [])
    {
        $plugins[] = $this->tracyPlugin = new TracyPlugin();
        $this->pluginClient = new PluginClient($client, $plugins, $options);
    }

    /**
     * @param RequestInterface $request
     * @return ResponseInterface
     */
    public function sendRequest(RequestInterface $request): ResponseInterface
    {
        $start = microtime(true);
        $response = $this->pluginClient->sendRequest($request);

        MessageCollector::addMessage(
            $this->tracyPlugin->getLastRequest() ?? $request,
            $response,
            microtime(true) - $start
        );

        return $response;
    }

    /**
     * @param RequestInterface $request
     * @return Promise
     */
    public function sendAsyncRequest(RequestInterface $request): Promise
    {
        return $this->pluginClient->sendAsyncRequest($request);
    }
}
