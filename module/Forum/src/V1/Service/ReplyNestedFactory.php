<?php

namespace Forum\V1\Service;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

class ReplyNestedFactory implements FactoryInterface
{
    /**
     * @param  \Interop\Container\ContainerInterface  $container
     * @param  mixed  $requestedName
     * @param  array  $options
     * @return \Forum\V1\Service\ReplyNested
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $service = new ReplyNested();

        return $service;
    }
}
