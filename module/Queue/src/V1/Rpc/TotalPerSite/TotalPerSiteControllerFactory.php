<?php
namespace Queue\V1\Rpc\TotalPerSite;

class TotalPerSiteControllerFactory
{
    public function __invoke($controllers)
    {
        $queueSiteMapper = $controllers->get(\Queue\Mapper\Site::class);
        $queueLogDailySummaryMapper = $controllers->get(\Queue\Mapper\LogDailySummary::class);

        return new TotalPerSiteController(
            $queueSiteMapper,
            $queueLogDailySummaryMapper
        );
    }
}
