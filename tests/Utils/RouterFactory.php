<?php

declare(strict_types=1);

namespace FreezyBee\Httplug\Tests\Utils;

use Nette\Application\IRouter;
use Nette\Application\Routers\Route;
use Nette\StaticClass;

/**
 * @author Jakub Janata <jakubjanata@gmail.com>
 */
class RouterFactory
{
    use StaticClass;

    /**
     * @return IRouter
     */
    public static function createRouter(): IRouter
    {
        return new Route('', 'Test:');
    }
}
