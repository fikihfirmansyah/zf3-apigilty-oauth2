<?php

namespace Queue\V1\Service\Listener;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

class DeviceEventListenerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $config = $container->get('Config')['project'];
        $queueDeviceMapper = $container->get(\Queue\Mapper\Device::class);
        $queueDeviceHydrator = $container->get('HydratorManager')->get('Queue\Hydrator\Device');
        $logger = $container->get('logger_default');

        $eventListener = new DeviceEventListener(
            $config,
            $queueDeviceMapper,
            $queueDeviceHydrator,
            $logger
        );

        return $eventListener;
    }
}
