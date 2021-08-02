<?php
namespace Queue;

use Zend\Mvc\MvcEvent;
use Zend\Stdlib\ArrayUtils;
use ZF\Apigility\Provider\ApigilityProviderInterface;

class Module implements ApigilityProviderInterface
{
    public function onBootstrap(MvcEvent $mvcEvent)
    {
        $serviceManager = $mvcEvent->getApplication()->getServiceManager();

        $queueLogService = $serviceManager->get(\Queue\V1\Service\Log::class);
        $queueLogEventListener = $serviceManager->get(\Queue\V1\Service\Listener\LogEventListener::class);
        $queueLogEventListener->attach($queueLogService->getEventManager());

        $queueSiteService = $serviceManager->get(\Queue\V1\Service\Site::class);
        $queueSiteEventListener = $serviceManager->get(\Queue\V1\Service\Listener\SiteEventListener::class);
        $queueSiteEventListener->attach($queueSiteService->getEventManager());

        $queueDeviceService = $serviceManager->get(\Queue\V1\Service\Device::class);
        $queueDeviceEventListener = $serviceManager->get(\Queue\V1\Service\Listener\DeviceEventListener::class);
        $queueDeviceEventListener->attach($queueDeviceService->getEventManager());
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
