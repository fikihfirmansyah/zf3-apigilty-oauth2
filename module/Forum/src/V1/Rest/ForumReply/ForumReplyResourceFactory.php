<?php

namespace Forum\V1\Rest\ForumReply;

class ForumReplyResourceFactory
{
    public function __invoke($services)
    {
        $forumReplyMapper = $services->get(\Forum\Mapper\Reply::class);
        $forumReplyService = $services->get(\Forum\V1\Service\Reply::class);


        return new ForumReplyResource($forumReplyMapper, $forumReplyService);
    }
}
