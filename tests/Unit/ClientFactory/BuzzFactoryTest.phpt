<?php
declare(strict_types=1);

namespace FreezyBee\Httplug\Tests\Unit\ClientFactory;

require __DIR__ . '/../../bootstrap.php';

use Http\Adapter\Buzz\Client;
use FreezyBee\Httplug\ClientFactory\BuzzFactory;
use Http\Message\MessageFactory;
use Mockery;
use Tester\Assert;
use Tester\TestCase;

/**
 * @author Tobias Nyholm <tobias.nyholm@gmail.com>
 */
class BuzzFactoryTest extends TestCase
{
    public function testCreateClient(): void
    {
        $factory = new BuzzFactory(Mockery::mock(MessageFactory::class));
        $client = $factory->createClient();

        Assert::true($client instanceof Client);
    }
}

(new BuzzFactoryTest)->run();

