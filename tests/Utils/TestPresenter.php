<?php
declare(strict_types=1);

namespace FreezyBee\Httplug\Tests\Utils;

use Http\Client\Common\PluginClient;
use Http\Message\MessageFactory;
use Nette\Application\Responses\TextResponse;
use Nette\Application\UI\Presenter;

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
        $pluginClient = $this->context->getService('httplug.client.test5');

        /** @var MessageFactory $factory */
        $factory = $this->context->getByType(MessageFactory::class);
        $request = $factory->createRequest('GET', '/test');

        $pluginClient->sendRequest($request);

        $this->sendResponse(new TextResponse('x'));
    }
}
