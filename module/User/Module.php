<?php
namespace User;

use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\ModuleManager\Feature\ConfigProviderInterface;
use Zend\Mvc\MvcEvent;
use ZF\MvcAuth\MvcAuthEvent;
use ZF\Apigility\Provider\ApigilityProviderInterface;

class Module implements
    ApigilityProviderInterface,
    AutoloaderProviderInterface,
    ConfigProviderInterface
{
    public function onBootstrap(MvcEvent $mvcEvent)
    {
        $serviceManager = $mvcEvent->getApplication()->getServiceManager();
        $eventManager = $mvcEvent->getApplication()->getEventManager();
        $mvcAuthEvent = new MvcAuthEvent(
            $mvcEvent,
            $serviceManager->get('authentication'),
            $serviceManager->get('authorization')
        );
        $pdoAdapter = $serviceManager->get('user.auth.pdo.adapter');
        $pdoAdapter->setEventManager($eventManager);
        $pdoAdapter->setMvcAuthEvent($mvcAuthEvent);
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
            $config = \Zend\Stdlib\ArrayUtils::merge($config, include $configFile, true);
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
