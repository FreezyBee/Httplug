<?php

declare(strict_types=1);

namespace FreezyBee\Httplug\ClientFactory;

use Http\Adapter\Guzzle7\Client;
use Http\Client\HttpClient;
use LogicException;

/**
 * @author Tobias Nyholm <tobias.nyholm@gmail.com>
 */
class Guzzle7Factory implements ClientFactory
{
    public function createClient(array $config = []): HttpClient
    {
        if (!class_exists(Client::class)) {
            throw new LogicException(
                'To use the Guzzle7 adapter you need to install the "php-http/guzzle7-adapter" package.'
            );
        }

        return Client::createWithConfig($config);
    }
}
