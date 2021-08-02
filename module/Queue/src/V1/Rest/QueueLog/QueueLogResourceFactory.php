<?php
namespace Queue\V1\Rest\QueueLog;

class QueueLogResourceFactory
{
    public function __invoke($services)
    {
        $queueLogMapper = $services->get(\Queue\Mapper\Log::class);
        $queueLogService = $services->get(\Queue\V1\Service\Log::class);
        $logger = $services->get('logger_default');

        return new QueueLogResource($queueLogMapper, $queueLogService, $logger);
    }
}
