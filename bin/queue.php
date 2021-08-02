<?php

require_once __DIR__ . '/../vendor/autoload.php'; // Composer autoloader

use Queue\V1\Console\SaveDailyLogSummary;
use Zend\Mvc\Application as MvcApplication;
use Zend\Stdlib\ArrayUtils;
use Zend\Console\Console;
use ZF\Console\Application;
use ZF\Console\Dispatcher;

define('APP_NAME', 'IWK QMS QUEUE');
define('VERSION', '0.0.1');

// loading all services
$mvcConfig = include __DIR__ . '/../config/application.config.php';
if (file_exists(__DIR__ . '/../config/development.config.php')) {
    $mvcConfig = ArrayUtils::merge($mvcConfig, include __DIR__ . '/../config/development.config.php');
}

$mvcApplication = MvcApplication::init($mvcConfig);
$dispatcher = new Dispatcher($mvcApplication->getServiceManager());

$dispatcher->map('save-daily-log-summary', function ($route, $console) use ($mvcApplication) {
    $handler = new SaveDailyLogSummary($mvcApplication->getServiceManager());
    $handler($route, $console);
});

$application = new Application(
    APP_NAME,
    VERSION,
    include __DIR__ . '/../config/console.queue.route.php',
    Console::getInstance(),
    $dispatcher
);

$application->setBannerDisabledForUserCommands(true);
$application->setDebug(true);
$exit = $application->run();

exit($exit);
