<?php

namespace News\V1\Service\Listener;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

class CommentsEventListenerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $config = $container->get('Config')['project'];
        $newsCommentsMapper = $container->get(\News\Mapper\Comments::class);
        $newsCommentsHydrator = $container->get('HydratorManager')->get('News\Hydrator\Comments');
        $logger = $container->get('logger_default');

        $invoicesEventListener = new CommentsEventListener(
            $config,
            $newsCommentsMapper,
            $newsCommentsHydrator,
            $logger
        );

        return $invoicesEventListener;
    }
}
