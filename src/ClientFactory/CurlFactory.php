<?php

declare(strict_types=1);

namespace FreezyBee\Httplug\ClientFactory;

use Http\Client\Curl\Client;
use Http\Client\HttpClient;
use LogicException;

/**
 * @author Tobias Nyholm <tobias.nyholm@gmail.com>
 */
class CurlFactory implements ClientFactory
{
    /**
     * {@inheritdoc}
     * @throws \LogicException
     */
    public function createClient(array $config = []): HttpClient
    {
        if (!class_exists(Client::class)) {
            throw new LogicException('To use the Curl client you need to install the "php-http/curl-client" package.');
        }

        // Try to resolve curl constant names
        foreach ($config as $key => $value) {
            // If the $key is a string we assume it is a constant
            if (\is_string($key)) {
                if (null === ($constantValue = \constant($key))) {
                    throw new LogicException(sprintf('Key %s is not an int nor a CURL constant', $key));
                }

                unset($config[$key]);
                $config[$constantValue] = $value;
            }
        }

        return new Client(null, null, $config);
    }
}
