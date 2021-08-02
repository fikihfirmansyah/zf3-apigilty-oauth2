<?php

namespace Queue\V1\Service\Listener;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

class LogEventListenerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $config = $container->get('Config')['project'];
        $queueLogMapper = $container->get(\Queue\Mapper\Log::class);
        $queueLogHydrator = $container->get('HydratorManager')->get('Queue\Hydrator\Log');
        $logger = $container->get('logger_default');

        $invoicesEventListener = new LogEventListener(
            $config,
            $queueLogMapper,
            $queueLogHydrator,
            $logger
        );

        return $invoicesEventListener;
    }
}
