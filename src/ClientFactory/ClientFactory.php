<?php

declare(strict_types=1);

namespace FreezyBee\Httplug\ClientFactory;

use Psr\Http\Client\ClientInterface;

/**
 * @author Tobias Nyholm <tobias.nyholm@gmail.com>
 */
interface ClientFactory
{
    /**
     * @param array<mixed> $config
     */
    public function createClient(array $config = []): ClientInterface;
}
