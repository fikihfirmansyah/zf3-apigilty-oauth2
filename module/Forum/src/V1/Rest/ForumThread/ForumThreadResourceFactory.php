<?php

namespace Forum\V1\Rest\ForumThread;

class ForumThreadResourceFactory
{
    public function __invoke($services)
    {
        $forumThreadMapper = $services->get(\Forum\Mapper\Thread::class);
        $forumThreadService = $services->get(\Forum\V1\Service\Thread::class);

        return new ForumThreadResource($forumThreadMapper, $forumThreadService);
    }
}
