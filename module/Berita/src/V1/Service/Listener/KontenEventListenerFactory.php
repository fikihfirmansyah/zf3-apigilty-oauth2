<?php

namespace Berita\V1\Service\Listener;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

class KontenEventListenerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $config = $container->get('Config')['project'];
        $beritaKontenMapper = $container->get(\Berita\Mapper\Konten::class);
        $beritaKontenHydrator = $container->get('HydratorManager')->get('Berita\Hydrator\Konten');
        $logger = $container->get('logger_default');

        $invoicesEventListener = new KontenEventListener(
            $config,
            $beritaKontenMapper,
            $beritaKontenHydrator,
            $logger
        );

        return $invoicesEventListener;
    }
}
