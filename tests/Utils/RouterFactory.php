<?php

declare(strict_types=1);

namespace FreezyBee\Httplug\Tests\Utils;

use Nette\Application\Routers\Route;
use Nette\Routing\Router;
use Nette\StaticClass;

/**
 * @author Jakub Janata <jakubjanata@gmail.com>
 */
class RouterFactory
{
    use StaticClass;

    public static function createRouter(): Router
    {
        return new Route('', 'Test:');
    }
}
