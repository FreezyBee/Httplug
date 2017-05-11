<?php
declare(strict_types=1);

namespace FreezyBee\Httplug\Tests\Unit\ClientFactory;

require __DIR__ . '/../../bootstrap.php';

use FreezyBee\Httplug\ClientFactory\CurlFactory;
use Http\Client\Curl\Client;
use Http\Message\MessageFactory;
use Http\Message\StreamFactory;
use Mockery;
use Tester\Assert;
use Tester\TestCase;

/**
 * @author Tobias Nyholm <tobias.nyholm@gmail.com>
 */
class CurlFactoryTest extends TestCase
{
    public function testCreateClient(): void
    {
        $factory = new CurlFactory(Mockery::mock(MessageFactory::class), Mockery::mock(StreamFactory::class));
        $client = $factory->createClient();

        Assert::true($client instanceof Client);
    }
}

(new CurlFactoryTest)->run();

