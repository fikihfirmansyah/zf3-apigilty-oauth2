<?php
namespace Queue\V1\Rpc\ExportQueueSummary;

use OAuth2\Request as OAuth2Request;

class ExportQueueSummaryControllerFactory
{
    public function __invoke($controllers)
    {
        $config  = $controllers->get('Config');
        $viewRenderer   = $controllers->get('ViewRenderer');
        $oauth2server = $controllers->get('ZF\OAuth2\Service\OAuth2Server');
        $oauth2request = OAuth2Request::createFromGlobals();
        $queueLogSummaryMapper   = $controllers->get(\Queue\Mapper\LogDailySummary::class);
        $csvExportService  = $controllers->get(\Queue\Export\Service\CsvExport::class);

        return new ExportQueueSummaryController(
            $config,
            $oauth2server(),
            $oauth2request,
            $queueLogSummaryMapper,
            $csvExportService,
            $viewRenderer
        );
    }
}
