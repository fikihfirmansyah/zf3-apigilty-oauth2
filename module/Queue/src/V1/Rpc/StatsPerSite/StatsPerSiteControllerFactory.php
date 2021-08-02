<?php
namespace Queue\V1\Rpc\StatsPerSite;

class StatsPerSiteControllerFactory
{
    public function __invoke($controllers)
    {
        $queueSiteMapper = $controllers->get(\Queue\Mapper\Site::class);
        $queueDeviceMapper = $controllers->get(\Queue\Mapper\Device::class);
        $queueLogMapper = $controllers->get(\Queue\Mapper\Log::class);
        $quueeLogDailySummaryMapper = $controllers->get(\Queue\Mapper\LogDailySummary::class);

        return new StatsPerSiteController(
            $queueSiteMapper,
            $queueDeviceMapper,
            $queueLogMapper,
            $quueeLogDailySummaryMapper
        );
    }
}
