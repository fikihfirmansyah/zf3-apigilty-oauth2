<?php

namespace Berita\V1\Service;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

class KontenFactory implements FactoryInterface
{
    /**
     * @param  \Interop\Container\ContainerInterface  $container
     * @param  mixed  $requestedName
     * @param  array  $options
     * @return \Berita\V1\Service\Konten
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $service = new Konten();

        return $service;
    }
}
