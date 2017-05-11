<?php
declare(strict_types=1);

namespace FreezyBee\Httplug\Tracy;

use Nette\StaticClass;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * @author Jakub Janata <jakubjanata@gmail.com>
 */
class MessageCollector
{
    use StaticClass;

    /** @var array */
    public static $messages = [];

    /** @var float */
    public static $totalTime;

    /**
     * @param RequestInterface $request
     * @param ResponseInterface $response
     * @param float $time
     */
    public static function addMessage(RequestInterface $request, ResponseInterface $response, float $time): void
    {
        self::$messages[] = [
            'request' => $request,
            'response' => $response,
            'time' => $time
        ];

        self::$totalTime += $time;
    }

    /**
     * @param ResponseInterface|RequestInterface $resource
     * @return mixed
     */
    public static function convertBodyToJsonObject($resource)
    {
        $body = $resource->getBody()->getContents();
        if (!$body) {
            return null;
        }

        if ($resource->hasHeader('Content-Type') &&
            strpos($resource->getHeader('Content-Type')[0], 'application/json') !== false
        ) {
            return json_decode($body);
        }

        return $body;
    }
}
