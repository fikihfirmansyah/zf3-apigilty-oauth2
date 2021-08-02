<?php
namespace User\V1\Rpc\Me;

class MeControllerFactory
{
    public function __invoke($controllers)
    {
        $auth = $controllers->get('authentication');
        $identity = $auth->getIdentity()
                        ->getAuthenticationIdentity();
        $me = null;
        if(is_array($identity) && isset($identity['user_id']))
            $me = $controllers->get(\User\Mapper\Account::class)
                    ->fetchOneBy(['username' => $identity['user_id']]);

        return new MeController($me);
    }
}
