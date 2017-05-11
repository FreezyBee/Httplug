<?php
declare(strict_types=1);

namespace FreezyBee\Httplug\ClientFactory;

use Http\Client\Curl\Client;
use Http\Client\HttpClient;
use Http\Message\MessageFactory;
use Http\Message\StreamFactory;
use LogicException;

/**
 * @author Tobias Nyholm <tobias.nyholm@gmail.com>
 */
class CurlFactory implements ClientFactory
{
    /**
     * @var MessageFactory
     */
    private $messageFactory;

    /**
     * @var StreamFactory
     */
    private $streamFactory;

    /**
     * @param MessageFactory $messageFactory
     * @param StreamFactory $streamFactory
     */
    public function __construct(MessageFactory $messageFactory, StreamFactory $streamFactory)
    {
        $this->messageFactory = $messageFactory;
        $this->streamFactory = $streamFactory;
    }

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
            if (is_string($key)) {
                if (null === ($constantValue = constant($key))) {
                    throw new LogicException(sprintf('Key %s is not an int nor a CURL constant', $key));
                }

                unset($config[$key]);
                $config[$constantValue] = $value;
            }
        }

        return new Client($this->messageFactory, $this->streamFactory, $config);
    }
}
