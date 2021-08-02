<?php
namespace User\Service\Listener;

use Zend\ServiceManager\Factory\FactoryInterface;
use Interop\Container\ContainerInterface;

class ClientAuthorizationListenerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $config = $container->get('Config');

        $userAccountMapper = $container->get(\User\Mapper\Account::class);
        $logger = $container->get("logger_default");
        $webAppConfig = $config['project']['web'];
        $mobileConfig = $config['project']['mobile'];

        $mvcAuthEventListener = new ClientAuthorizationListener(
            $userAccountMapper,
            $logger,
            $webAppConfig,
            $mobileConfig
        );

        return $mvcAuthEventListener;
    }
}
