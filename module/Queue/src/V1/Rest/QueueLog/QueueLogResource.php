<?php
namespace Queue\V1\Rest\QueueLog;

use Psr\Log\LoggerAwareTrait;
use Queue\Entity\Log;
use RuntimeException;
use Zend\InputFilter\InputFilter;
use Zend\Paginator\Paginator;
use Zend\View\Model\JsonModel;
use ZF\ApiProblem\ApiProblem;
use ZF\ApiProblem\ApiProblemResponse;
use ZF\Hal\View\HalJsonModel;
use ZF\Rest\AbstractResourceListener;

class QueueLogResource extends AbstractResourceListener
{
    use LoggerAwareTrait;

    /**
     * @var \Queue\Mapper\Log
     */
    protected $queueLogMapper;

    /**
     * @var \Queue\V1\Service\Log
     */
    protected $queueLogService;

    /**
     * @param  \Queue\Mapper\Log  $queueLogMapper
     * @param  \Queue\V1\Service\Log  $queueLogService
     * @param  mixed  $logger
     */
    public function __construct($queueLogMapper, $queueLogService, $logger)
    {
        $this->queueLogMapper = $queueLogMapper;
        $this->queueLogService = $queueLogService;
        $this->logger = $logger;
    }

    /**
     * Create a resource
     *
     * @param  mixed $data
     * @return ApiProblem|mixed
     */
    public function create($data)
    {
        try {
            $input = $this->getInputFilter();

            if($input->getValue('counter') === '0')
                return new JsonModel();

            $input->add(['name'  => 'device']);
            $input->get('device')->setValue($input->getValue('deviceId'));
            $input->remove('deviceId');

            $input->add(['name'  => 'counterNumber']);
            $input->get('counterNumber')->setValue($input->getValue('counter'));
            $input->remove('counter');

            $input->add(['name'  => 'reservedTime']);
            $input->get('reservedTime')->setValue($input->getValue('printTicketTime'));
            $input->remove('printTicketTime');

            $input->add(['name' => 'waitingTime']);
            $input->get('waitingTime')->setValue(NULL);
            $input->add(['name' => 'processingTime']);
            $input->get('processingTime')->setValue(NULL);

            if($input->getValue('calledTime') !== NULL && $input->getValue('calledTime') !== '') {
                $input->get('waitingTime')->setValue(
                    $this->dateDiffInMinutes(
                        $input->getValue('reservedTime'),
                        $input->getValue('calledTime'))
                );
            }
            try {
                new \DateTime($input->getValue('calledTime'));
            } catch(\Exception $ex) {
                $input->remove('calledTime');
            }
            if($input->getValue('calledTime') !== NULL && $input->getValue('calledTime') !== '') {
                $prevLog = $this->getPrevLog($input);
                if($prevLog !== NULL && $prevLog instanceof Log) {
                    $input2 = new InputFilter();
                    $input2->add(['name' => 'endTime']);
                    $input2->get('endTime')->setValue($input->getValue('calledTime'));
                    $input2->add(['name' => 'processingTime']);
                    $input2->get('processingTime')->setValue(
                        $this->dateDiffInMinutes(
                            $prevLog->getCalledTime()->format('Y-m-d H:i:s'),
                            $input2->getValue('endTime'))
                    );

                    $this->queueLogService->update($prevLog, $input2);
                }
            }
            $input->remove('endTime');

            if($log = $this->checkIfExists($input)) {
                return $this->queueLogService->update($log, $input);
            } else {
                return $this->queueLogService->save($input);
            }
        } catch(RuntimeException $ex) {
            return new ApiProblemResponse(new ApiProblem(500, $ex->getMessage()));
        }
    }

    /**
     * @param  string  $dateString1
     * @param  string  $dateString2
     * @return float
     */
    protected function dateDiffInMinutes($dateString1, $dateString2)
    {
        $date1 = new \DateTime($dateString1);
        $date2 = new \DateTime($dateString2);
        $_date1 = strtotime($date1->format('Y-m-d H:i:s'));
        $_date2 = strtotime($date2->format('Y-m-d H:i:s'));

        return round(abs($_date1-$_date2) / 60, 2);
    }

    /**
     * @param  \Zend\InputFilter\InputFilterInterface
     * @return \Queue\Entity\Log|null
     */
    protected function checkIfExists($input)
    {
        return $this->queueLogMapper->fetchOneBy([
            'device'        => $input->getValue('device'),
            'number'        => $input->getValue('number'),
            'counterNumber' => $input->getValue('counterNumber'),
            'reservedTime'  => new \DateTime($input->getValue('reservedTime')),
        ]);
    }

    /**
     * @param  \Zend\InputFilter\InputFilterInterface  $input
     * @return \Queue\Entity\Log|null
     */
    protected function getPrevLog($input)
    {
        $prevLogs = $this->queueLogMapper->fetchAll([
                        'device'        => $input->getValue('device'),
                        'counter'       => $input->getValue('counterNumber'),
                        // 'end_number'    => $input->getValue('number'),
                        'start_date'    => $input->getValue('reservedTime'),
                        'end_date'      => $input->getValue('reservedTime'),
                        'end_time'      => 'NULL',
                    ], 'number', 'DESC', 20)
                    ->getResult();
        foreach($prevLogs as $prevLog) {
            if($prevLog->getNumber() !== $input->getValue('number'))
                return $prevLog;
        }
        return NULL;
    }

    /**
     * Delete a resource
     *
     * @param  mixed $id
     * @return ApiProblem|mixed
     */
    public function delete($id)
    {
        try {
            $queueLog = $this->queueLogMapper->fetchOneBy(['uuid' => $id]);
            if(!$queueLog)
                return new ApiProblem(404, 'Queue Log data not found.');

            return $this->queueLogService->delete($queueLog);
        } catch(RuntimeException $ex) {
            return new ApiProblemResponse(new ApiProblem(500, $ex->getMessage()));
        }
    }

    /**
     * Delete a collection, or members of a collection
     *
     * @param  mixed $data
     * @return ApiProblem|mixed
     */
    public function deleteList($data)
    {
        return new ApiProblem(405, 'The DELETE method has not been defined for collections');
    }

    /**
     * Fetch a resource
     *
     * @param  mixed $id
     * @return ApiProblem|mixed
     */
    public function fetch($id)
    {
        $queueLog = $this->queueLogMapper->fetchOneBy(['uuid' => $id]);
        if(!$queueLog)
            return new ApiProblemResponse(new ApiProblem(404, 'Queue Log data not found.'));

        return $queueLog;
    }

    /**
     * Fetch all or a subset of resources
     *
     * @param  array $params
     * @return ApiProblem|mixed
     */
    public function fetchAll($params = [])
    {
        if(!is_array($params))
            $params = $params->toArray();

        $qb = $this->queueLogMapper->fetchAll(
            $params,
            $params['order'] ?? null,
            $params['ascending'] ?? false
        );

        $adapter = $this->queueLogMapper->createPaginatorAdapter($qb);
        return new Paginator($adapter);
    }

    /**
     * Patch (partial in-place update) a resource
     *
     * @param  mixed $id
     * @param  mixed $data
     * @return ApiProblem|mixed
     */
    public function patch($id, $data)
    {
        try {
            $queueLog = $this->queueLogMapper->fetchOneBy(['uuid' => $id]);
            if(!$queueLog)
                return new ApiProblemResponse(new ApiProblem(404, 'Queue Log data not found!'));

            $input = $this->getInputFilter();
            $input->add(['name' => 'updatedAt']);
            $input->get('updatedAt')->setValue(new \DateTime('now'));

            return $this->queueLogService->update($queueLog, $input);
        } catch(RuntimeException $ex) {
            return new ApiProblemResponse(new ApiProblem(500, $ex->getMessage()));
        }
    }

    /**
     * Patch (partial in-place update) a collection or members of a collection
     *
     * @param  mixed $data
     * @return ApiProblem|mixed
     */
    public function patchList($data)
    {
        return new ApiProblem(405, 'The PATCH method has not been defined for collections');
    }

    /**
     * Replace a collection or members of a collection
     *
     * @param  mixed $data
     * @return ApiProblem|mixed
     */
    public function replaceList($data)
    {
        return new ApiProblem(405, 'The PUT method has not been defined for collections');
    }

    /**
     * Update a resource
     *
     * @param  mixed $id
     * @param  mixed $data
     * @return ApiProblem|mixed
     */
    public function update($id, $data)
    {
        return new ApiProblem(405, 'The PUT method has not been defined for individual resources');
    }
}
