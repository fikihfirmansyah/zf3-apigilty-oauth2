<?php

namespace News\V1\Rest\Contents;

class ContentsResourceFactory
{
    public function __invoke($services)
    {
        $contentsMapper = $services->get(\News\Mapper\Contents::class);
        $contentsService = $services->get(\News\V1\Service\Contents::class);

        return new ContentsResource($contentsMapper, $contentsService);
    }
}
