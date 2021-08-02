<?php

namespace Berita\V1\Service\Listener;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

class KomentarEventListenerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $config = $container->get('Config')['project'];
        $beritaKomentarMapper = $container->get(\Berita\Mapper\Komentar::class);
        $beritaKomentarHydrator = $container->get('HydratorManager')->get('Berita\Hydrator\Komentar');
        $logger = $container->get('logger_default');

        $invoicesEventListener = new KomentarEventListener(
            $config,
            $beritaKomentarMapper,
            $beritaKomentarHydrator,
            $logger
        );

        return $invoicesEventListener;
    }
}
