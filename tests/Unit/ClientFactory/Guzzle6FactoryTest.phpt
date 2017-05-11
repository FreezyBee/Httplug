<?php
declare(strict_types=1);

namespace FreezyBee\Httplug\Tests\Unit\ClientFactory;

require __DIR__ . '/../../bootstrap.php';

use FreezyBee\Httplug\ClientFactory\Guzzle6Factory;
use Http\Adapter\Guzzle6\Client;
use Tester\Assert;
use Tester\TestCase;

/**
 * @author Tobias Nyholm <tobias.nyholm@gmail.com>
 */
class Guzzle6FactoryTest extends TestCase
{
    public function testCreateClient(): void
    {
        $factory = new Guzzle6Factory();
        $client = $factory->createClient();

        Assert::true($client instanceof Client);
    }
}

(new Guzzle6FactoryTest)->run();
