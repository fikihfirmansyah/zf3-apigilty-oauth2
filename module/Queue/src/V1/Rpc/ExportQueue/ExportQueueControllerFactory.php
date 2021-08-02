<?php
namespace Queue\V1\Rpc\ExportQueue;

use OAuth2\Request as OAuth2Request;

class ExportQueueControllerFactory
{
    public function __invoke($controllers)
    {
        $config  = $controllers->get('Config');
        $viewRenderer   = $controllers->get('ViewRenderer');
        $oauth2server = $controllers->get('ZF\OAuth2\Service\OAuth2Server');
        $oauth2request = OAuth2Request::createFromGlobals();
        $queueLogMapper   = $controllers->get(\Queue\Mapper\Log::class);
        $queueLogService  = $controllers->get(\Queue\V1\Service\Log::class);
        $csvExportService  = $controllers->get(\Queue\Export\Service\CsvExport::class);

        return new ExportQueueController(
            $config,
            $oauth2server(),
            $oauth2request,
            $queueLogMapper,
            $queueLogService,
            $csvExportService,
            $viewRenderer
        );
    }
}
