<?php

namespace Forum\V1\Rest\ForumReply;

use RuntimeException;
use Zend\Paginator\Paginator;
use ZF\ApiProblem\ApiProblem;
use ZF\ApiProblem\ApiProblemResponse;
use ZF\Rest\AbstractResourceListener;

class ForumReplyResource extends AbstractResourceListener
{
    protected $forumReplyMapper;
    protected $forumReplyService;

    public function __construct($forumReplyMapper, $forumReplyService)
    {
        $this->forumReplyMapper = $forumReplyMapper;
        $this->forumReplyService = $forumReplyService;
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

            return $this->forumReplyService->save($input);
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
            $forumReply = $this->forumReplyMapper->fetchOneBy(['uuid' => $id]);
            if (!$forumReply)
                return new ApiProblem(404, 'Queue Site data not found.');

            return $this->forumReplyService->delete($forumReply);
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
        $forumReply = $this->forumReplyMapper->fetchOneBy(['uuid' => $id]);
        if (!$forumReply)
            return new ApiProblemResponse(new ApiProblem(404, 'ForumReply data not found.'));

        return $forumReply;
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

        $qb = $this->forumReplyMapper->fetchAll(
            $params,
            $params['order'] ?? null,
            $params['ascending'] ?? false
        );

        $adapter = $this->forumReplyMapper->createPaginatorAdapter($qb);
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
            $forumReply = $this->forumReplyMapper->fetchOneBy(['uuid' => $id]);
            if (!$forumReply)
                return new ApiProblemResponse(new ApiProblem(404, 'Queue Site data not found!'));

            $input = $this->getInputFilter();
            $input->add(['name' => 'updatedAt']);

            return $this->forumReplyService->update($forumReply, $input);
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
