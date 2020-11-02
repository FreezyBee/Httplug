<?php
declare(strict_types=1);

namespace FreezyBee\Httplug\Tests\Unit\ClientFactory;

require __DIR__ . '/../../bootstrap.php';

use FreezyBee\Httplug\ClientFactory\Guzzle7Factory;
use Http\Adapter\Guzzle7\Client;
use Tester\Assert;
use Tester\TestCase;

/**
 * @author Tobias Nyholm <tobias.nyholm@gmail.com>
 */
class Guzzle7FactoryTest extends TestCase
{
    public function testCreateClient(): void
    {
        if (!class_exists(Client::class)) {
            Assert::true(true); // TODO condition in CI
            return;
        }

        $factory = new Guzzle7Factory();
        $client = $factory->createClient();

        Assert::true($client instanceof Client);
    }
}

(new Guzzle7FactoryTest)->run();
