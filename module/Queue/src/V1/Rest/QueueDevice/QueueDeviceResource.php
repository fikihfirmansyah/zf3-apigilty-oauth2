<?php
namespace Queue\V1\Rest\QueueDevice;

use Psr\Log\LoggerAwareTrait;
use RuntimeException;
use Zend\Paginator\Paginator;
use ZF\ApiProblem\ApiProblem;
use ZF\ApiProblem\ApiProblemResponse;
use ZF\Rest\AbstractResourceListener;

class QueueDeviceResource extends AbstractResourceListener
{
    use LoggerAwareTrait;

    /**
     * @var \Queue\Mapper\Device
     */
    protected $queueDeviceMapper;

    /**
     * @var \Queue\V1\Service\Device
     */
    protected $queueDeviceService;

    /**
     * @param  \Queue\Mapper\Device  $queueDeviceMapper
     * @param  \Queue\V1\Service\Device  $queueDeviceService
     * @param  mixed  $logger
     */
    public function __construct($queueDeviceMapper, $queueDeviceService, $logger)
    {
        $this->queueDeviceMapper = $queueDeviceMapper;
        $this->queueDeviceService = $queueDeviceService;
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

            return $this->queueDeviceService->save($input);
        } catch(RuntimeException $ex) {
            return new ApiProblemResponse(new ApiProblem(500, $ex->getMessage()));
        }
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
            $queueDevice = $this->queueDeviceMapper->fetchOneBy(['uuid' => $id]);
            if(!$queueDevice)
                return new ApiProblem(404, 'Queue Device data not found.');

            return $this->queueDeviceService->delete($queueDevice);
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
        $queueDevice = $this->queueDeviceMapper->fetchOneBy(['uuid' => $id]);
        if(!$queueDevice)
            return new ApiProblemResponse(new ApiProblem(404, 'Queue Device data not found.'));

        return $queueDevice;
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

        $qb = $this->queueDeviceMapper->fetchAll(
            $params,
            $params['order'] ?? null,
            $params['ascending'] ?? false
        );

        $adapter = $this->queueDeviceMapper->createPaginatorAdapter($qb);
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
            $queueDevice = $this->queueDeviceMapper->fetchOneBy(['uuid' => $id]);
            if(!$queueDevice)
                return new ApiProblemResponse(new ApiProblem(404, 'Queue Device data not found!'));

            $input = $this->getInputFilter();
            $input->add(['name' => 'updatedAt']);
            $input->get('updatedAt')->setValue(new \DateTime('now'));

            return $this->queueDeviceService->update($queueDevice, $input);
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
