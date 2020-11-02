<?php

declare(strict_types=1);

namespace FreezyBee\Httplug\ClientFactory;

use Http\Adapter\Guzzle6\Client;
use Http\Client\HttpClient;
use LogicException;

/**
 * @author Tobias Nyholm <tobias.nyholm@gmail.com>
 */
class Guzzle6Factory implements ClientFactory
{
    /**
     * {@inheritdoc}
     * @throws LogicException
     */
    public function createClient(array $config = []): HttpClient
    {
        if (!class_exists(Client::class)) {
            throw new LogicException(
                'To use the Guzzle6 adapter you need to install the "php-http/guzzle6-adapter" package.'
            );
        }

        return Client::createWithConfig($config);
    }
}
