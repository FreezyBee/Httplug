<?php
declare(strict_types=1);

namespace FreezyBee\Httplug\ClientFactory;

use Buzz\Client\FileGetContents;
use Http\Adapter\Buzz\Client as Adapter;
use Http\Client\HttpClient;
use Http\Message\MessageFactory;
use LogicException;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * @author Tobias Nyholm <tobias.nyholm@gmail.com>
 */
class BuzzFactory implements ClientFactory
{
    /**
     * @var MessageFactory
     */
    private $messageFactory;

    /**
     * @param MessageFactory $messageFactory
     */
    public function __construct(MessageFactory $messageFactory)
    {
        $this->messageFactory = $messageFactory;
    }

    /**
     * {@inheritdoc}
     * @throws LogicException
     */
    public function createClient(array $config = []): HttpClient
    {
        if (!class_exists(Adapter::class)) {
            throw new LogicException(
                'To use the Buzz adapter you need to install the "php-http/buzz-adapter" package.'
            );
        }

        $client = new FileGetContents();
        $options = $this->getOptions($config);

        $client->setTimeout($options['timeout']);
        $client->setVerifyPeer($options['verify_peer']);
        $client->setVerifyHost($options['verify_host']);
        $client->setProxy($options['proxy']);

        return new Adapter($client, $this->messageFactory);
    }

    /**
     * Get options to configure the Buzz client.
     *
     * @param array $config
     * @return array
     */
    private function getOptions(array $config = []): array
    {
        $resolver = new OptionsResolver();

        $resolver->setDefaults([
            'timeout' => 5,
            'verify_peer' => true,
            'verify_host' => 2,
            'proxy' => null,
        ]);

        $resolver->setAllowedTypes('timeout', 'int');
        $resolver->setAllowedTypes('verify_peer', 'bool');
        $resolver->setAllowedTypes('verify_host', 'int');
        $resolver->setAllowedTypes('proxy', ['string', 'null']);

        return $resolver->resolve($config);
    }
}
