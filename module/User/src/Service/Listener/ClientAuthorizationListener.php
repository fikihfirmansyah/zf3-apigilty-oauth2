<?php
namespace User\Service\Listener;

use ZF\MvcAuth\MvcAuthEvent;
use Psr\Log\LoggerAwareTrait;
use Psr\Log\LoggerInterface;
use User\Mapper\Account as UserAccountMapper;

class ClientAuthorizationListener
{
    use LoggerAwareTrait;

    /**
     * @var \User\Mapper\Account
     */
    protected $userAccountMapper;

    /**
     * @var array
     */
    protected $mobileConfig;

    /**
     * @var array
     */
    protected $webAppConfig;

    public function __construct(
        UserAccountMapper $userAccountMapper,
        LoggerInterface $logger,
        $webAppConfig,
        $mobileConfig
    ) {
        $this->userAccountMapper = $userAccountMapper;
        $this->logger = $logger;
        $this->webAppConfig = $webAppConfig;
        $this->mobileConfig = $mobileConfig;
    }

    /**
     * Check activated
     *
     * @param  MvcAuthEvent
     */
    public function __invoke(MvcAuthEvent $mvcAuthEvent)
    {
        $credentials = $mvcAuthEvent->getIdentity()->getAuthenticationIdentity();
        if (! is_string($credentials)) {
            return;
        }

        $payloads    = json_decode($mvcAuthEvent->getMvcEvent()->getRequest()->getContent());
        $userAccount = $this->userAccountMapper->fetchOneBy(['username' => $credentials]);
        $clientId    = $payloads->client_id;
        $mvcEvent    = $mvcAuthEvent->getMvcEvent();
        $request     = $mvcEvent->getRequest();

        $webAppConfig = $this->webAppConfig;
        $mobileConfig = $this->mobileConfig;

        $isWebAppRequest = preg_match(
            '/(' . $webAppConfig['allowed_client_id'] . ')/',
            $clientId
        );
        $isMobileAppRequest = preg_match(
            '/(' . $mobileConfig['allowed_client_id']['patient'] . ')/',
            $clientId
        );

        return;
    }
}
