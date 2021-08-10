<?php

namespace Forum;

use Zend\Mvc\MvcEvent;
use Zend\Stdlib\ArrayUtils;
use ZF\Apigility\Provider\ApigilityProviderInterface;

class Module implements ApigilityProviderInterface
{
    public function onBootstrap(MvcEvent $mvcEvent)
    {
        $serviceManager = $mvcEvent->getApplication()->getServiceManager();

        $forumThreadService = $serviceManager->get(\Forum\V1\Service\Thread::class);
        $forumThreadEventListener = $serviceManager->get(\Forum\V1\Service\Listener\ThreadEventListener::class);
        $forumThreadEventListener->attach($forumThreadService->getEventManager());

        $forumReplyService = $serviceManager->get(\Forum\V1\Service\Reply::class);
        $forumReplyEventListener = $serviceManager->get(\Forum\V1\Service\Listener\ReplyEventListener::class);
        $forumReplyEventListener->attach($forumReplyService->getEventManager());

        $forumReplyNestedService = $serviceManager->get(\Forum\V1\Service\ReplyNested::class);
        $forumReplyNestedEventListener = $serviceManager->get(\Forum\V1\Service\Listener\ReplyNestedEventListener::class);
        $forumReplyNestedEventListener->attach($forumReplyNestedService->getEventManager());
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
                ]
            ],
        ];
    }
}
