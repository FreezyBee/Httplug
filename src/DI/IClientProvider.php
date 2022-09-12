<?php

declare(strict_types=1);

namespace FreezyBee\Httplug\DI;

/**
 * @author Jakub Janata <jakubjanata@gmail.com>
 */
interface IClientProvider
{
    /**
     * Return array of client configs
     * clientName:
     *      factory: ...
     *      plugins:
     *          ...

     * @return array<mixed>
     */
    public function getClientConfigs(): array;
}
