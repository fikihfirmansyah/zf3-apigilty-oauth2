<?php

namespace Forum\V1\Service\Listener;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

class ReplyNestedEventListenerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $config = $container->get('Config')['project'];
        $forumReplyNestedMapper = $container->get(\Forum\Mapper\ReplyNested::class);
        $forumReplyNestedHydrator = $container->get('HydratorManager')->get('Forum\Hydrator\ReplyNested');
        $logger = $container->get('logger_default');

        $invoicesEventListener = new ReplyNestedEventListener(
            $config,
            $forumReplyNestedMapper,
            $forumReplyNestedHydrator,
            $logger
        );

        return $invoicesEventListener;
    }
}
