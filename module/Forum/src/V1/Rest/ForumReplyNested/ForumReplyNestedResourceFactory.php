<?php

namespace Forum\V1\Rest\ForumReplyNested;

class ForumReplyNestedResourceFactory
{
    public function __invoke($services)
    {
        $forumReplyNestedMapper = $services->get(\Forum\Mapper\ReplyNested::class);
        $forumReplyNestedService = $services->get(\Forum\V1\Service\ReplyNested::class);


        return new ForumReplyNestedResource($forumReplyNestedMapper, $forumReplyNestedService);
    }
}
