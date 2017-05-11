<?php
declare(strict_types=1);

namespace FreezyBee\Httplug\ClientFactory;

use Http\Adapter\React\Client;
use Http\Client\HttpClient;
use Http\Message\MessageFactory;
use LogicException;

/**
 * @author Tobias Nyholm <tobias.nyholm@gmail.com>
 */
class ReactFactory implements ClientFactory
{
    /**
     * @var MessageFactory
     */
    private $messageFactory;

    /**
     * @param MessageFactory $messageFactory
     */
    public function __construct(MessageFactory $messageFactory)
    {
        $this->messageFactory = $messageFactory;
    }

    /**
     * {@inheritdoc}
     * @throws LogicException
     */
    public function createClient(array $config = []): HttpClient
    {
        if (!class_exists(Client::class)) {
            throw new LogicException(
                'To use the React adapter you need to install the "php-http/react-adapter" package.'
            );
        }

        return new Client($this->messageFactory);
    }
}
