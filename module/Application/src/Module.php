<?php
/**
 * @license   http://opensource.org/licenses/BSD-3-Clause BSD-3-Clause
 * @copyright Copyright (c) 2014-2016 Zend Technologies USA Inc. (http://www.zend.com)
 */

namespace Application;

use Zend\Uri\UriFactory;
use Zend\Mvc\MvcEvent;

class Module
{
    public function onBootstrap(MvcEvent $mvcEvent)
    {
        UriFactory::registerScheme('chrome-extension', 'Zend\Uri\Uri'); // add chrome-extension for API Client
        $serviceManager = $mvcEvent->getApplication()->getServiceManager();
        $eventManager   = $mvcEvent->getApplication()->getEventManager();
        $sharedEventManager = $eventManager->getSharedManager();

        // modify firebase service
        $processBuilder  = $serviceManager->get('Aqilix\Service\PhpProcessBuilder');
        $firebaseService = $serviceManager->get(\Xtend\Firebase\Service\Firebase::class);
        $apnsService  = $serviceManager->get(\Xtend\Apns\Service\Apns::class);
        $emailService = $serviceManager->get(\Xtend\Email\Service\Email::class);
        $smsService   = $serviceManager->get('\Xtend\Sms\Service\Sms');

        // set firebase adapter
        $firebaseCliAdapter = new \Xtend\Firebase\Adapter\Cli;
        $firebaseCliAdapter->setPhpProcessBuilder($processBuilder);
        $firebaseCliAdapter->setLogger($serviceManager->get("logger_default"));
        $firebaseService->setAdapter($firebaseCliAdapter);

        // set apns adapter
        $apnsCliAdapter = new \Xtend\Apns\Adapter\Cli;
        $apnsCliAdapter->setPhpProcessBuilder($processBuilder);
        $apnsCliAdapter->setLogger($serviceManager->get("logger_default"));
        $apnsService->setAdapter($apnsCliAdapter);

        // set  adapter
        $emailProcessBuilder = $serviceManager->get("\Xtend\Email\Service\PhpProcessBuilder");
        $emailCliAdapter = new \Xtend\Email\Adapter\Cli;
        $emailCliAdapter->setPhpProcessBuilder($emailProcessBuilder);
        $emailCliAdapter->setLogger($serviceManager->get("logger_default"));
        $emailService->setAdapter($emailCliAdapter);

        // set  adapter
//        $smsProcessBuilder = $serviceManager->get("\Xtend\Zenziva\Service\PhpProcessBuilder");
//        $smsCliAdapter = new \Xtend\Zenziva\Adapter\Cli;
//        $smsCliAdapter->setPhpProcessBuilder($smsProcessBuilder);
//        $smsCliAdapter->setLogger($serviceManager->get("zenziva_logger"));

        // set  adapter
        // $gosmsProcessBuilder = $serviceManager->get("\Xtend\GoSms\Service\PhpProcessBuilder");
        // $gosmsCliAdapter = new \Xtend\GoSms\Adapter\Cli;
        // $gosmsCliAdapter->setPhpProcessBuilder($gosmsProcessBuilder);
        // $gosmsCliAdapter->setLogger($serviceManager->get("gosms_logger"));
        // $smsService->setAdapter($gosmsCliAdapter);

        // set  adapter
        // $manasikProcessBuilder = $serviceManager->get("\Xtend\Manasik\Service\PhpProcessBuilder");
        // $manasikCliAdapter = new \Xtend\Manasik\Adapter\Cli;
        // $manasikCliAdapter->setPhpProcessBuilder($manasikProcessBuilder);
        // $manasikCliAdapter->setLogger($serviceManager->get("gosms_logger"));
        // $smsService->setAdapter($manasikCliAdapter);
    }

    public function getConfig()
    {
        return include __DIR__ . '/../config/module.config.php';
    }
}
