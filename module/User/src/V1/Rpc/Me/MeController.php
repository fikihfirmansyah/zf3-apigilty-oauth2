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

    public function __construct($me){
        $this->me = $me;
    }

    public function meAction()
    {
        var_dump('entah'); exit(0);
        return 'entah';
    }
}
