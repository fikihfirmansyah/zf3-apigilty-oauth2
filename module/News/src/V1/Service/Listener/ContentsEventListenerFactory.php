<?php

namespace News\V1\Service\Listener;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

class ContentsEventListenerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $config = $container->get('Config')['project'];
        $newsContentsMapper = $container->get(\News\Mapper\Contents::class);
        $newsContentsHydrator = $container->get('HydratorManager')->get('News\Hydrator\Contents');
        $logger = $container->get('logger_default');

        $invoicesEventListener = new ContentsEventListener(
            $config,
            $newsContentsMapper,
            $newsContentsHydrator,
            $logger
        );

        return $invoicesEventListener;
    }
}
