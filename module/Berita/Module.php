<?php

namespace Berita;

use Zend\Mvc\MvcEvent;
use Zend\Stdlib\ArrayUtils;
use ZF\Apigility\Provider\ApigilityProviderInterface;

class Module implements ApigilityProviderInterface
{
    public function onBootstrap(MvcEvent $mvcEvent)
    {
        $serviceManager = $mvcEvent->getApplication()->getServiceManager();

        $beritaKontenService = $serviceManager->get(\Berita\V1\Service\Konten::class);
        $beritaKontenEventListener = $serviceManager->get(\Berita\V1\Service\Listener\KontenEventListener::class);
        $beritaKontenEventListener->attach($beritaKontenService->getEventManager());

        $beritaKomentarService = $serviceManager->get(\Berita\V1\Service\Komentar::class);
        $beritaKomentarEventListener = $serviceManager->get(\Berita\V1\Service\Listener\KomentarEventListener::class);
        $beritaKomentarEventListener->attach($beritaKomentarService->getEventManager());
    }
    public function getConfig()
    {
        $config = [];
        $configFiles = [
            __DIR__ . '/config/module.config.php',
            __DIR__ . '/config/doctrine.config.php',  // configuration for doctrine
        ];

        // merge all module config options
        foreach ($configFiles as $configFile) {
            $config = ArrayUtils::merge($config, include $configFile, true);
        }

        return $config;
    }

    public function getAutoloaderConfig()
    {
        return [
            'ZF\Apigility\Autoloader' => [
                'namespaces' => [
                    __NAMESPACE__ => __DIR__ . '/src',
                ],
            ],
        ];
    }
}
