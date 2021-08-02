<?php
namespace Queue\V1\Rest\QueueDevice;

class QueueDeviceResourceFactory
{
    public function __invoke($services)
    {
        $queueDeviceMapper = $services->get(\Queue\Mapper\Device::class);
        $queueDeviceService = $services->get(\Queue\V1\Service\Device::class);
        $logger = $services->get('logger_default');

        return new QueueDeviceResource($queueDeviceMapper, $queueDeviceService, $logger);
    }
}
