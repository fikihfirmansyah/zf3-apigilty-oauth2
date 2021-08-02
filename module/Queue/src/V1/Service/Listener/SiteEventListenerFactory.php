<?php

namespace Queue\V1\Service\Listener;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

class SiteEventListenerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $config = $container->get('Config')['project'];
        $queueSiteMapper = $container->get(\Queue\Mapper\Site::class);
        $queueSiteHydrator = $container->get('HydratorManager')->get('Queue\Hydrator\Site');
        $logger = $container->get('logger_default');

        $invoicesEventListener = new SiteEventListener(
            $config,
            $queueSiteMapper,
            $queueSiteHydrator,
            $logger
        );

        return $invoicesEventListener;
    }
}
