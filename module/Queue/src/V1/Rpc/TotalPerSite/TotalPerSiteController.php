<?php
namespace Queue\V1\Rpc\TotalPerSite;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\JsonModel;
use ZF\ApiProblem\ApiProblem;
use ZF\ApiProblem\ApiProblemResponse;

class TotalPerSiteController extends AbstractActionController
{
    /**
     * @var \Queue\Mapper\Site
     */
    protected $siteMapper;

    /**
     * @var \Queue\Mapper\LogDailySummary
     */
    protected $logDailySummaryMapper;

    /**
     * @param  \Queue\Mapper\Site  $siteMapper
     * @param  \Queue\Mapper\LogDailySummary  $logDailySummaryMapper
     */
    public function __construct($siteMapper, $logDailySummaryMapper)
    {
        $this->siteMapper = $siteMapper;
        $this->logDailySummaryMapper = $logDailySummaryMapper;
    }

    public function totalPerSiteAction()
    {
        $queryParams = $this->getRequest()->getQuery()->toArray();
        if(!isset($queryParams['limit']))
            $queryParams['limit'] = 7;

        try {
            $start = null; $end = null;
            if(isset($queryParams['start_date']) && isset($queryParams['end_date'])) {
                $start = new \DateTime($queryParams['start_date']);
                $end = new \DateTime($queryParams['end_date']);
            } else {
                $start = new \DateTime('-'.$queryParams['limit'].' days');
                $end = new \DateTime('now');
            }
            $end->add(\DateInterval::createFromDateString('1 day'));

            $interval = \DateInterval::createFromDateString('1 day');
            $period = new \DatePeriod($start, $interval, $end);

            $response = [];
            foreach($period as $dt) {
                // $results = $this->siteMapper
                //             ->getTotalPerSite([
                //                 'start_date'    => $dt->format('Y-m-d'),
                //                 'end_date'      => $dt->format('Y-m-d'),
                //             ])
                //             ->getResult();
                $results = $this->siteMapper
                            ->getTotalPerSite2([
                                'start_date'    => $dt->format('Y-m-d'),
                                'end_date'      => $dt->format('Y-m-d'),
                            ])
                            ->getArrayResult();

                $totalPerSites = [];
                foreach($results as $result) {
                    $totalPerSites[] = [
                        'site'      => $result['site'],
                        'total'     => (int)($result['totalQueue'] ?? 0),
                    ];
                }

                $response[] = [
                    'date' => $dt->format('Y-m-d'),
                    'content' => $totalPerSites,
                ];
            }

            return new JsonModel($response);
        } catch(\Exception $ex) {
            return new ApiProblemResponse(new ApiProblem(400, $ex->getMessage()));
        }
    }
}
