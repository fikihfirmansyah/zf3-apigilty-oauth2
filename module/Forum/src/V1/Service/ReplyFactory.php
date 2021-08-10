<?php

namespace Forum\V1\Service;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

class ReplyFactory implements FactoryInterface
{
    /**
     * @param  \Interop\Container\ContainerInterface  $container
     * @param  mixed  $requestedName
     * @param  array  $options
     * @return \Forum\V1\Service\Reply
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $service = new Reply();

        return $service;
    }
}
