<?php
namespace Queue\V1\Rpc\WaitingTimePerDate;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\JsonModel;
use ZF\ApiProblem\ApiProblem;
use ZF\ApiProblem\ApiProblemResponse;

class WaitingTimePerDateController extends AbstractActionController
{
    /**
     * @var \Queue\Mapper\Site
     */
    protected $queueSiteMapper;

    /**
     * @var \Queue\Mapper\LogDailySummary
     */
    protected $queueLogDailySummaryMapper;

    /**
     * @param  \Queue\Mapper\Site  $queueSiteMapper
     * @param  \Queue\Mapper\LogDailySummary  $queueLogDailySummaryMapper
     */
    public function __construct($queueSiteMapper, $queueLogDailySummaryMapper)
    {
        $this->queueSiteMapper = $queueSiteMapper;
        $this->queueLogDailySummaryMapper = $queueLogDailySummaryMapper;
    }

    public function waitingTimePerDateAction()
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
                $results = $this->queueSiteMapper
                            ->getAvgWaitingTimePerSite([
                                'start_date'    => $dt->format('Y-m-d'),
                                'end_date'      => $dt->format('Y-m-d'),
                            ])
                            ->getArrayResult();

                $avgWaitingTimePerSites = [];
                foreach($results as $result) {
                    $avgWaitingTimePerSites[] = [
                        'site'              => $result['site'],
                        'avgWaitingTime'    => (int)($result['avgWaitingTime'] ?? 0),
                    ];
                }

                $response[] = [
                    'date'      => $dt->format('Y-m-d'),
                    'content'   => $avgWaitingTimePerSites,
                ];
            }

            return new JsonModel($response);
        } catch(\Exception $ex) {
            return new ApiProblemResponse(new ApiProblem(400, $ex->getMessage()));
        }
    }
}
