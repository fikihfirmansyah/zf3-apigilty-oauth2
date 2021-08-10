<?php

namespace Forum\V1\Service\Listener;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

class ThreadEventListenerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $config = $container->get('Config')['project'];
        $forumThreadMapper = $container->get(\Forum\Mapper\Thread::class);
        $forumThreadHydrator = $container->get('HydratorManager')->get('Forum\Hydrator\Thread');
        $logger = $container->get('logger_default');

        $invoicesEventListener = new ThreadEventListener(
            $config,
            $forumThreadMapper,
            $forumThreadHydrator,
            $logger
        );

        return $invoicesEventListener;
    }
}
