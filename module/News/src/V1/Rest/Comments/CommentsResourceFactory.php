<?php

namespace News\V1\Rest\Comments;

class CommentsResourceFactory
{
    public function __invoke($services)
    {
        $commentsMapper = $services->get(\News\Mapper\Comments::class);
        $commentsService = $services->get(\News\V1\Service\Comments::class);


        return new CommentsResource($commentsMapper, $commentsService);
    }
}
