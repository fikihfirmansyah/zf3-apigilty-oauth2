<?php
namespace Queue\V1\Rpc\StatsPerDate;

class StatsPerDateControllerFactory
{
    public function __invoke($controllers)
    {
        $queueSiteMapper = $controllers->get(\Queue\Mapper\Site::class);
        $queueDeviceMapper = $controllers->get(\Queue\Mapper\Device::class);
        $queueLogMapper = $controllers->get(\Queue\Mapper\Log::class);
        $quueeLogDailySummaryMapper = $controllers->get(\Queue\Mapper\LogDailySummary::class);

        return new StatsPerDateController(
            $queueSiteMapper,
            $queueDeviceMapper,
            $queueLogMapper,
            $quueeLogDailySummaryMapper
        );
    }
}
