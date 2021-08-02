<?php
namespace Queue\V1\Rest\QueueSite;

class QueueSiteResourceFactory
{
    public function __invoke($services)
    {
        $queueSiteMapper = $services->get(\Queue\Mapper\Site::class);
        $queueSiteService = $services->get(\Queue\V1\Service\Site::class);
        $logger = $services->get('logger_default');

        return new QueueSiteResource($queueSiteMapper, $queueSiteService, $logger);
    }
}
