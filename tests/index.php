<?php
declare(strict_types=1);

use Nette\Configurator;

require __DIR__ . '/../vendor/autoload.php';

\Tracy\Debugger::$editor = 'phpstorm://open?file=%file&line=%line';
$configurator = new Configurator;
$configurator->enableTracy();
$configurator->setTempDirectory(__DIR__ . '/tmp');
$configurator->addConfig(__DIR__ . '/config.neon');
$container = $configurator->createContainer();


$container->getService('application')->run();
