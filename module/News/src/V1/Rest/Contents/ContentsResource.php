<?php

namespace News\V1\Rest\Contents;

use RuntimeException;
use Zend\Paginator\Paginator;
use ZF\ApiProblem\ApiProblem;
use ZF\ApiProblem\ApiProblemResponse;
use ZF\Rest\AbstractResourceListener;

class ContentsResource extends AbstractResourceListener
{
    protected $contentsMapper;
    protected $contentsService;

    public function __construct($contentsMapper, $contentsService)
    {
        $this->contentsMapper = $contentsMapper;
        $this->contentsService = $contentsService;
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

            return $this->contentsService->save($input);
        } catch (RuntimeException $ex) {
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
            $newsContents = $this->contentsMapper->fetchOneBy(['uuid' => $id]);
            if (!$newsContents)
                return new ApiProblem(404, 'Queue Site data not found.');

            return $this->contentsService->delete($newsContents);
        } catch (RuntimeException $ex) {
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
        $contents = $this->contentsMapper->fetchOneBy(['uuid' => $id]);
        if (!$contents)
            return new ApiProblemResponse(new ApiProblem(404, 'Contents data not found.'));

        return $contents;
    }


    /**
     * Fetch all or a subset of resources
     *
     * @param  array $params
     * @return ApiProblem|mixed
     */
    public function fetchAll($params = [])
    {
        if (!is_array($params))
            $params = $params->toArray();

        $qb = $this->contentsMapper->fetchAll(
            $params,
            $params['order'] ?? null,
            $params['ascending'] ?? false
        );

        $adapter = $this->contentsMapper->createPaginatorAdapter($qb);
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
            $newsContents = $this->contentsMapper->fetchOneBy(['uuid' => $id]);
            if (!$newsContents)
                return new ApiProblemResponse(new ApiProblem(404, 'Queue Site data not found!'));

            $input = $this->getInputFilter();
            $input->add(['name' => 'updatedAt']);

            return $this->contentsService->update($newsContents, $input);
        } catch (RuntimeException $ex) {
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
