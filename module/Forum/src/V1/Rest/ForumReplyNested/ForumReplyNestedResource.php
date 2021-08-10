<?php

namespace Forum\V1\Rest\ForumReplyNested;

use RuntimeException;
use Zend\Paginator\Paginator;
use ZF\ApiProblem\ApiProblem;
use ZF\ApiProblem\ApiProblemResponse;
use ZF\Rest\AbstractResourceListener;

class ForumReplyNestedResource extends AbstractResourceListener
{
    protected $forumReplyNestedMapper;
    protected $forumReplyNestedService;

    public function __construct($forumReplyNestedMapper, $forumReplyNestedService)
    {
        $this->forumReplyNestedMapper = $forumReplyNestedMapper;
        $this->forumReplyNestedService = $forumReplyNestedService;
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

            return $this->forumReplyNestedService->save($input);
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
            $forumReplyNested = $this->forumReplyNestedMapper->fetchOneBy(['uuid' => $id]);
            if (!$forumReplyNested)
                return new ApiProblem(404, 'Queue Site data not found.');

            return $this->forumReplyNestedService->delete($forumReplyNested);
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
        $forumReplyNested = $this->forumReplyNestedMapper->fetchOneBy(['uuid' => $id]);
        if (!$forumReplyNested)
            return new ApiProblemResponse(new ApiProblem(404, 'ForumReplyNested data not found.'));

        return $forumReplyNested;
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

        $qb = $this->forumReplyNestedMapper->fetchAll(
            $params,
            $params['order'] ?? null,
            $params['ascending'] ?? false
        );

        $adapter = $this->forumReplyNestedMapper->createPaginatorAdapter($qb);
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
            $forumReplyNested = $this->forumReplyNestedMapper->fetchOneBy(['uuid' => $id]);
            if (!$forumReplyNested)
                return new ApiProblemResponse(new ApiProblem(404, 'Queue Site data not found!'));

            $input = $this->getInputFilter();
            $input->add(['name' => 'updatedAt']);

            return $this->forumReplyNestedService->update($forumReplyNested, $input);
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
