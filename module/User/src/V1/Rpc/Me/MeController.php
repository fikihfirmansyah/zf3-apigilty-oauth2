<?php

namespace User\V1\Rpc\Me;

use Zend\Mvc\Controller\AbstractActionController;
use ZF\ContentNegotiation\ViewModel;
use ZF\ApiProblem\ApiProblemResponse;
use ZF\ApiProblem\ApiProblem;
use ZF\Hal\View\HalJsonModel;

class MeController extends AbstractActionController
{
    protected $me;

    public function __construct($me)
    {
        $this->me = $me;
    }

    public function meAction()
    {
        $userProfile = [];
        if (!is_null($this->userProfile)) {
            return new HalJsonModel(['uuid'  => $this->userProfile->getUuid()]);
        } else {
            return new ApiProblemResponse(new ApiProblem(404, "User Identity not found"));
        }
    }
}
