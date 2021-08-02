<?php

namespace News\V1\Service;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

class CommentsFactory implements FactoryInterface
{
    /**
     * @param  \Interop\Container\ContainerInterface  $container
     * @param  mixed  $requestedName
     * @param  array  $options
     * @return \News\V1\Service\Comments
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $service = new Comments();

        return $service;
    }
}
