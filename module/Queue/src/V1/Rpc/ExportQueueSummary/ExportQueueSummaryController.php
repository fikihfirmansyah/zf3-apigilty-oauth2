<?php
namespace Queue\V1\Rpc\ExportQueueSummary;

use Dompdf\Dompdf;
use Dompdf\Options as DomOptions;
use Zend\Mvc\Controller\AbstractActionController;
use ZF\Apigility\Documentation\Swagger\ViewModel;

class ExportQueueSummaryController extends AbstractActionController
{
    /**
     * @var mixed
     */
    protected $config;

    /**
     * @var mixed
     */
    protected $oauth2server;

    /**
     * @var \OAuth2\Request
     */
    protected $oauth2request;

    /**
     * @var \Queue\Mapper\LogDailySummary
     */
    protected $queueLogSummaryMapper;

    /**
     * @var \Queue\Export\Service\CsvExport
     */
    protected $csvExportService;

    /**
     * @var mixed
     */
    protected $viewRenderer;

    /**
     * @param  mixed  $config
     * @param  mixed  $oauth2server
     * @param  \OAuth2\Request  $oauth2request
     * @param  \Queue\Mapper\LogDailySummary  $queueLogSummaryMapper
     * @param  \Queue\Export\Service\CsvExport  $csvExportService
     * @param  mixed  $viewRenderer
     */
    public function __construct(
        $config,
        $oauth2server,
        $oauth2request,
        $queueLogSummaryMapper,
        $csvExportService,
        $viewRenderer
    ) {
        $this->config = $config;
        $this->oauth2server = $oauth2server;
        $this->oauth2request = $oauth2request;
        $this->queueLogSummaryMapper = $queueLogSummaryMapper;
        $this->csvExportService = $csvExportService;
        $this->viewRenderer = $viewRenderer;
    }

    public function totalCsvAction()
    {
        $queryParams = $this->getRequest()->getQuery()->toArray();

        // check token and validate
        if (isset($queryParams['token'])) {
            $this->oauth2request->headers['AUTHORIZATION'] = 'Bearer ' . $queryParams['token'];
            $tokenData = $this->oauth2server->getAccessTokenData($this->oauth2request);
            if (is_null($tokenData))
                return $this->getResponse()->setStatusCode(401);
        } else {
            return $this->getResponse()->setStatusCode(403);
        }

        $time = time();
        $queryBuilder = $this->queueLogSummaryMapper
                            ->getStats($queryParams);
        $exportFileName = $this->createCsv($queryBuilder);
        return $this->csvExportService->responseStreamFile(
            $exportFileName,
            'total-queue-'.$time.'.csv'
        );
    }

    public function totalPdfAction()
    {
        $params = $this->getRequest()->getQuery()->toArray();

        // check token and validate
        if (isset($params['token'])) {
            $this->oauth2request->headers['AUTHORIZATION'] = 'Bearer ' . $params['token'];
            $tokenData = $this->oauth2server->getAccessTokenData($this->oauth2request);
            if (is_null($tokenData))
                return $this->getResponse()->setStatusCode(401);
        } else {
            return $this->getResponse()->setStatusCode(403);
        }

        $queryBuilder = $this->queueLogSummaryMapper->getStats($params);
        $results = $queryBuilder->getArrayResult();

        $records = [];
        foreach ($results as $index => $result) {
            $record = [
                'no'                => ($index + 1),
                'siteName'          => $result['siteName'],
                'deviceName'        => $result['deviceName'],
                'counterNumber'     => $result['counterNumber'],
                'totalQueue'        => (int)$result['totalQueue'],
                'avgWaitingTime'    => number_format((float)$result['avgWaitingTime'], 2),
                'avgProcessingTime' => number_format((float)$result['avgProcessingTime'], 2),
            ];
            $records[] = $record;
        }

        $logoPath = "data/logo/iwk-logo-trans.png";
        $view = new ViewModel([
            'logoPath'  => $logoPath,
            'data' => $records,
            'date' => (new \DateTime('now'))->format('Y-m-d'),
        ]);

        $view->setTemplate('pdf/total-queue.phtml');
        $html = $this->viewRenderer->render($view);
        $this->sendToPdf($html, (new \DateTime('now'))->format('Y-m-d'));

        return $view;
    }

    /**
     * @param  \Doctrine\ORM\Query  $queryBuilder
     * @return mixed
     */
    public function createCsv($queryBuilder)
    {
        $tmpfname = tempnam('/tmp', 'report-ot-');
        $results  = $queryBuilder->getArrayResult();
        $record   = [];
        $file     = fopen($tmpfname, 'w');
        $headers = [
            'No.',
            'Site',
            'Device',
            'Counter',
            'Total Queue',
            'Average Processing Time (minutes)',
            'Averate Waiting Time (minutes)',
        ];
        fputcsv($file, $headers);

        foreach ($results as $index => $result) {
            $record = [
                ($index + 1),
                $result['siteName'],
                $result['deviceName'],
                $result['counterNumber'],
                (int)$result['totalQueue'],
                number_format((float)$result['avgWaitingTime'], 2),
                number_format((float)$result['avgProcessingTime'], 2),
            ];
            fputcsv($file, $record);
        }

        fclose($file);

        return $tmpfname;
    }

    /**
     * @param  mixed  $html
     * @param  string  $date
     */
    function sendToPdf($html, $date)
    {
        $options = new DomOptions();
        $options->setIsRemoteEnabled(true);
        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'potrait');
        $dompdf->render();
        $dompdf->stream('total-queue-'.$date);
    }

    /**
     * @param  \DateTime|null  $input
     * @return string
     */
    protected function formatDateTimeMaybeNull($input)
    {
        if($input !== null && $input instanceof \DateTime)
            return $input->format('Y-m-d');
        return '';
    }
}
