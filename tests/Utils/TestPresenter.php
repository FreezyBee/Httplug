<?php

declare(strict_types=1);

namespace FreezyBee\Httplug\Tests\Utils;

use Http\Client\Common\PluginClient;
use Nette\Application\Responses\TextResponse;
use Nette\Application\UI\Presenter;
use Psr\Http\Message\RequestFactoryInterface;

/**
 * @author Jakub Janata <jakubjanata@gmail.com>
 */
class TestPresenter extends Presenter
{
    /**
     *
     */
    public function actionDefault(): void
    {
        /** @var PluginClient $pluginClient */
        $pluginClient = $this->context->getService('httplug.client.test2');
        dump($pluginClient);

        /** @var PluginClient $pluginClient */
        $pluginClient = $this->context->getService('httplug.client.test5');

        /** @var RequestFactoryInterface $factory */
        $factory = $this->context->getByType(RequestFactoryInterface::class);
        $request = $factory->createRequest('GET', '/test');

        $pluginClient->sendRequest($request);

        $this->sendResponse(new TextResponse('x'));
    }
}
