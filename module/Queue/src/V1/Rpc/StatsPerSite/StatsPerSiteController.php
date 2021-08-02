<?php
namespace Queue\V1\Rpc\StatsPerSite;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\JsonModel;
use ZF\ApiProblem\ApiProblem;
use ZF\ApiProblem\ApiProblemResponse;

class StatsPerSiteController extends AbstractActionController
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
    public function statsPerSiteAction()
    {
        $queryParams = $this->getRequest()->getQuery()->toArray();

        try {
            $result = null;

            $results = $this->queueLogDailySummaryMapper
                        ->getStats($queryParams)
                        ->getResult();

            $response = [];
            foreach($results as $result) {
                $response[] = [
                    'site'      => $result['siteName'],
                    'device'    => $result['deviceName'],
                    'counter'   => $result['counterNumber'],
                    'summary'   => [
                        'totalQueue'        => (int)$result['totalQueue'],
                        'avgProcessingTime' => (float)number_format((float)$result['avgProcessingTime'], 2),
                        'avgWaitingTime'    => (float)number_format((float)$result['avgWaitingTime'], 2),
                    ]
                ];
            }

            return new JsonModel($response);
        } catch(\Exception $ex) {
            return new ApiProblemResponse(new ApiProblem(400, $ex->getMessage()));
        }
    }
}
