<?php

declare(strict_types=1);

namespace FreezyBee\Httplug\Tests\Utils;

use Http\Client\Common\Plugin;
use Http\Promise\Promise;
use Psr\Http\Message\RequestInterface;

/**
 * @author Jakub Janata <jakubjanata@gmail.com>
 */
class TestPlugin implements Plugin
{
    /** @var array<mixed> */
    public array $config;
    public object $service;

    /**
     * @param array<mixed> $config
     */
    public function __construct(array $config, object $service)
    {
        $this->config = $config;
        $this->service = $service;
    }

    /**
     * {@inheritdoc}
     */
    public function handleRequest(RequestInterface $request, callable $next, callable $first): Promise
    {
        return $next($request);
    }
}
