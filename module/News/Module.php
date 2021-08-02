<?php

namespace News;

use Zend\Mvc\MvcEvent;
use Zend\Stdlib\ArrayUtils;
use ZF\Apigility\Provider\ApigilityProviderInterface;

class Module implements ApigilityProviderInterface
{
    public function onBootstrap(MvcEvent $mvcEvent)
    {
        $serviceManager = $mvcEvent->getApplication()->getServiceManager();

        $newsContentsService = $serviceManager->get(\News\V1\Service\Contents::class);
        $newsContentsEventListener = $serviceManager->get(\News\V1\Service\Listener\ContentsEventListener::class);
        $newsContentsEventListener->attach($newsContentsService->getEventManager());

        $newsCommentsService = $serviceManager->get(\News\V1\Service\Comments::class);
        $newsCommentsEventListener = $serviceManager->get(\News\V1\Service\Listener\CommentsEventListener::class);
        $newsCommentsEventListener->attach($newsCommentsService->getEventManager());
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
