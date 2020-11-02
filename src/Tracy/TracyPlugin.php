<?php

declare(strict_types=1);

namespace FreezyBee\Httplug\Tracy;

use Http\Client\Common\Plugin;
use Http\Promise\Promise;
use Nette\SmartObject;
use Psr\Http\Message\RequestInterface;

/**
 * @author Jakub Janata <jakubjanata@gmail.com>
 */
class TracyPlugin implements Plugin
{
    use SmartObject;

    /**
     * Last request
     * @var RequestInterface|null
     */
    private $request;

    /**
     * {@inheritdoc}
     */
    public function handleRequest(RequestInterface $request, callable $next, callable $first): Promise
    {
        $this->request = $request;
        return $next($request);
    }

    /**
     * @return RequestInterface|null
     */
    public function getLastRequest(): ?RequestInterface
    {
        return $this->request;
    }
}
