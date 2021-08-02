<?php
namespace Queue\V1\Rpc\TotalPerCounter;

class TotalPerCounterControllerFactory
{
    public function __invoke($controllers)
    {
        $queueLogMapper = $controllers->get(\Queue\Mapper\Log::class);
        $queueLogDailySummaryMapper = $controllers->get(\Queue\Mapper\LogDailySummary::class);

        return new TotalPerCounterController(
            $queueLogMapper,
            $queueLogDailySummaryMapper
        );
    }
}
