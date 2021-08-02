<?php
namespace Queue\V1\Rpc\WaitingTimePerDate;

class WaitingTimePerDateControllerFactory
{
    public function __invoke($controllers)
    {
        $queueSiteMapper = $controllers->get(\Queue\Mapper\Site::class);
        $queueLogDailySummaryMapper = $controllers->get(\Queue\Mapper\LogDailySummary::class);

        return new WaitingTimePerDateController(
            $queueSiteMapper,
            $queueLogDailySummaryMapper
        );
    }
}
