<?php

namespace Queue\V1\Service;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

class DeviceFactory implements FactoryInterface
{
    /**
     * @param  \Interop\Container\ContainerInterface  $container
     * @param  mixed  $requestedName
     * @param  array  $options
     * @return \Queue\V1\Service\Device
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $service = new Device();

        return $service;
    }
}
