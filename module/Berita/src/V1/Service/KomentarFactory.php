<?php

namespace Berita\V1\Service;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

class KomentarFactory implements FactoryInterface
{
    /**
     * @param  \Interop\Container\ContainerInterface  $container
     * @param  mixed  $requestedName
     * @param  array  $options
     * @return \Berita\V1\Service\Komentar
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $service = new Komentar();

        return $service;
    }
}
