<?php
namespace Queue\V1\Rpc\StatsPerDate;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\JsonModel;
use ZF\ApiProblem\ApiProblem;
use ZF\ApiProblem\ApiProblemResponse;

class StatsPerDateController extends AbstractActionController
{
    /**
     * @var \Queue\Mapper\Site
     */
    protected $queueSiteMapper;

    /**
     * @var \Queue\Mapper\Device
     */
    protected $queueDeviceMapper;

    /**
     * @var \Queue\Mapper\Log
     */
    protected $queueLogMapper;

    /**
     * @var \Queue\Mapper\LogDailySummary
     */
    protected $queueLogDailySummaryMapper;

    /**
     * @param  \Queue\Mapper\Site  $queueSiteMapper
     * @param  \Queue\Mapper\Device  $queueDeviceMapper
     * @param  \Queue\Mapper\Log  $queueLogMapper
     * @param  \Queue\Mapper\LogDailySummary  $queueLogDailySummaryMapper
     */
    public function __construct($queueSiteMapper, $queueDeviceMapper, $queueLogMapper, $queueLogDailySummaryMapper)
    {
        $this->queueSiteMapper = $queueSiteMapper;
        $this->queueDeviceMapper = $queueDeviceMapper;
        $this->queueLogMapper = $queueLogMapper;
        $this->queueLogDailySummaryMapper = $queueLogDailySummaryMapper;
    }

    /**
     * @return mixed
     */
    public function statsPerDateAction()
    {
        $queryParams = $this->getRequest()->getQuery()->toArray();
        if(!isset($queryParams['limit']))
            $queryParams['limit'] = 30;

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
                $results = $this->queueLogDailySummaryMapper
                            ->getStatsByDate([
                                'date' => $dt->format('Y-m-d'),
                                'limit' => 1,
                            ])
                            ->getResult();

                $totalQueue = 0;
                $avgProcessingTime = 0.0;
                $avgWaitingTime = 0.0;
                if(isset($results[0])) {
                    $totalQueue = $results[0]['totalQueue'] ?? 0;
                    $avgProcessingTime = $results[0]['avgProcessingTime'] ?? 0;
                    $avgWaitingTime = $results[0]['avgWaitingTime'] ?? 0;
                }

                $response[] = [
                    'date'   => $dt->format('Y-m-d'),
                    'summary'   => [
                        'totalQueue'        => (int)$totalQueue,
                        'avgProcessingTime' => (float)number_format((float)$avgProcessingTime, 2),
                        'avgWaitingTime'    => (float)number_format((float)$avgWaitingTime, 2),
                    ]
                ];
            }

            return new JsonModel($response);
        } catch(\Exception $ex) {
            return new ApiProblemResponse(new ApiProblem(400, $ex->getMessage()));
        }
    }
}
