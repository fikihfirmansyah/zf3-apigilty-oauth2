<?php
namespace Queue\V1\Rpc\TotalPerCounter;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\JsonModel;
use ZF\ApiProblem\ApiProblem;
use ZF\ApiProblem\ApiProblemResponse;

class TotalPerCounterController extends AbstractActionController
{
    /**
     * @var \Queue\Mapper\Log
     */
    protected $logMapper;

    /**
     * @var \Queue\Mapper\LogDailySummary
     */
    protected $logDailySummaryMapper;

    /**
     * @param  \Queue\Mapper\Log  $logMapper
     * @param  \Queue\Mapper\LogDailySummary  $logDailySummaryMapper
     */
    public function __construct($logMapper, $logDailySummaryMapper)
    {
        $this->logMapper = $logMapper;
        $this->logDailySummaryMapper = $logDailySummaryMapper;
    }

    public function totalPerCounterAction()
    {
        $queryParams = $this->getRequest()->getQuery()->toArray();

        try {
            $dates = [
                ['today', new \DateTime('now'), new \DateTime('now')],
                ['thisWeek', new \DateTime('-7 days'), new \DateTime('now')],
                ['last30days', new \DateTime('-30 days'), new \DateTime('now')],
            ];

            $response = [];
            foreach($dates as $date) {
                /**
                 * FIXME: Consider using a separated counter data table.
                 */
                $results = $this->logMapper
                            ->getTotalPerCounter([
                                'start_date'    => $date[1],
                                'end_date'      => $date[2],
                            ])
                            ->getArrayResult();

                $totalPerCounters = [];
                foreach($results as $result) {
                    $totalPerCounters[] = [
                        'counter'   => $result['counterNumber'],
                        'total'     => (int)($result['totalQueue'] ?? 0),
                    ];
                }

                $response[] = [
                    $date[0] => $totalPerCounters,
                ];
            }

            return new JsonModel($response);
        } catch(\Exception $ex) {
            return new ApiProblemResponse(new ApiProblem(400, $ex->getMessage()));
        }
    }
}
