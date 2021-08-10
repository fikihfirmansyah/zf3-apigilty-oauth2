<?php

namespace Forum\V1\Service\Listener;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

class ReplyEventListenerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $config = $container->get('Config')['project'];
        $forumReplyMapper = $container->get(\Forum\Mapper\Reply::class);
        $forumReplyHydrator = $container->get('HydratorManager')->get('Forum\Hydrator\Reply');
        $logger = $container->get('logger_default');

        $invoicesEventListener = new ReplyEventListener(
            $config,
            $forumReplyMapper,
            $forumReplyHydrator,
            $logger
        );

        return $invoicesEventListener;
    }
}
