<?php
namespace Queue\V1\Rest\QueueSite;

use Psr\Log\LoggerAwareTrait;
use RuntimeException;
use Zend\Paginator\Paginator;
use ZF\ApiProblem\ApiProblem;
use ZF\ApiProblem\ApiProblemResponse;
use ZF\Rest\AbstractResourceListener;

class QueueSiteResource extends AbstractResourceListener
{
    use LoggerAwareTrait;

    /**
     * @var \Queue\Mapper\Site
     */
    protected $queueSiteMapper;

    /**
     * @var \Queue\V1\Service\Site
     */
    protected $queueSiteService;

    /**
     * @param  \Queue\Mapper\Site  $queueSiteMapper
     * @param  \Queue\V1\Service\Site  $queueSiteService
     * @param  mixed  $logger
     */
    public function __construct($queueSiteMapper, $queueSiteService, $logger)
    {
        $this->queueSiteMapper = $queueSiteMapper;
        $this->queueSiteService = $queueSiteService;
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

            return $this->queueSiteService->save($input);
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
            $queueSite = $this->queueSiteMapper->fetchOneBy(['uuid' => $id]);
            if(!$queueSite)
                return new ApiProblem(404, 'Queue Site data not found.');

            return $this->queueSiteService->delete($queueSite);
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
        return new ApiProblem(405, 'The GET method has not been defined for individual resources');
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

        $qb = $this->queueSiteMapper->fetchAll(
            $params,
            $params['order'] ?? null,
            $params['ascending'] ?? false
        );

        $adapter = $this->queueSiteMapper->createPaginatorAdapter($qb);
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
            $queueSite = $this->queueSiteMapper->fetchOneBy(['uuid' => $id]);
            if(!$queueSite)
                return new ApiProblemResponse(new ApiProblem(404, 'Queue Site data not found!'));

            $input = $this->getInputFilter();
            $input->add(['name' => 'updatedAt']);
            $input->get('updatedAt')->setValue(new \DateTime('now'));

            return $this->queueSiteService->update($queueSite, $input);
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
