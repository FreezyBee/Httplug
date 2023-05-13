<?php

declare(strict_types=1);

namespace FreezyBee\Httplug\Tracy;

use Http\Client\Common\PluginClient;
use Nette\SmartObject;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * @author Jakub Janata <jakubjanata@gmail.com>
 */
class PluginClientDecorator implements ClientInterface
{
    use SmartObject;

    private PluginClient $pluginClient;
    private TracyPlugin $tracyPlugin;

    /**
     * @param array<mixed> $plugins
     * @param array<mixed> $options
     */
    public function __construct(ClientInterface $client, array $plugins = [], array $options = [])
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
}
