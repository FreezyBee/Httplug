<?php
declare(strict_types=1);

namespace FreezyBee\Httplug\Tests\Unit\ClientFactory;

require __DIR__ . '/../../bootstrap.php';

use Http\Adapter\React\Client;
use FreezyBee\Httplug\ClientFactory\ReactFactory;
use Http\Message\MessageFactory;
use Mockery;
use Tester\Assert;
use Tester\TestCase;

/**
 * @author Tobias Nyholm <tobias.nyholm@gmail.com>
 */
class ReactFactoryTest extends TestCase
{
    public function testCreateClient(): void
    {
        $factory = new ReactFactory(Mockery::mock(MessageFactory::class));
        $client = $factory->createClient();

        Assert::true($client instanceof Client);
    }
}

(new ReactFactoryTest)->run();
