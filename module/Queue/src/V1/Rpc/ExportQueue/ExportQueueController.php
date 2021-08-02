<?php
namespace Queue\V1\Rpc\ExportQueue;

use Dompdf\Dompdf;
use Dompdf\Options as DomOptions;
use Queue\Entity\Log as LogEntity;
use Zend\Mvc\Controller\AbstractActionController;
use ZF\Apigility\Documentation\Swagger\ViewModel;

class ExportQueueController extends AbstractActionController
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
     * @var \Queue\Mapper\Log
     */
    protected $queueLogMapper;

    /**
     * @var \Queue\V1\Service\Log
     */
    protected $queueLogService;

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
     * @param  \Queue\Mapper\Log  $queueLogMapper
     * @param  \Queue\V1\Service\Log  $queueLogService
     * @param  \Queue\Export\Service\CsvExport  $csvExportService
     * @param  mixed  $viewRenderer
     */
    public function __construct($config, $oauth2server, $oauth2request, $queueLogMapper, $queueLogService, $csvExportService, $viewRenderer)
    {
        $this->config = $config;
        $this->oauth2server = $oauth2server;
        $this->oauth2request = $oauth2request;
        $this->queueLogMapper = $queueLogMapper;
        $this->queueLogService = $queueLogService;
        $this->csvExportService = $csvExportService;
        $this->viewRenderer = $viewRenderer;
    }

    public function generalAction()
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

        if(!isset($params['start_date'])) {
            $params['start_date'] = (new \DateTime('now'))->format('Y-m-d');
        }

        if(!isset($params['end_date'])) {
            $params['end_date'] = (new \DateTime('now'))->format('Y-m-d');
        }

        $order = null;
        if (isset($queryParams['order'])) {
            $order = $queryParams['order'];
            unset($queryParams['order']);
        }

        $asc = false;
        if (isset($queryParams['ascending'])) {
            $asc = $queryParams['ascending'];
            unset($queryParams['ascending']);
        }

        $time = time();
        $queryBuilder = $this->queueLogMapper
                            ->fetchAll($queryParams, $order, $asc);
        $exportFileName = $this->queueLogService
                            ->exportQueueLog($queryBuilder);
        return $this->csvExportService->responseStreamFile(
            $exportFileName,
            'queue_list-'.$time.'.csv'
        );
    }

    public function pdfAction()
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

        if(!isset($params['start_date'])) {
            $params['start_date'] = (new \DateTime('now'))->format('Y-m-d');
        }

        if(!isset($params['end_date'])) {
            $params['end_date'] = (new \DateTime('now'))->format('Y-m-d');
        }

        $queryBuilder = $this->queueLogMapper->fetchAll($params);
        $results = $queryBuilder->getResult();

        $records = [];
        foreach ($results as $result) {
            if($result instanceof LogEntity) {
                $waitingTime = null;
                if($result->getWaitingTime())
                    $waitingTime = $result->getWaitingTime(). 'minute(s)';
                $processingTime = null;
                if($result->getProcessingTime())
                    $processingTime = $result->getProcessingTime(). 'minute(s)';
                $record = [
                    'number' => $result->getNumber(),
                    'counter_number' => $result->getCounterNumber(),
                    'reserved_time' => $this->formatDateTimeMaybeNull($result->getReservedTime()),
                    'called_time' => $this->formatDateTimeMaybeNull($result->getCalledTime()),
                    'end_time' => $this->formatDateTimeMaybeNull($result->getEndTime()),
                    'waiting_time' => $waitingTime,
                    'processing_time' => $processingTime,
                    'site_name' => $result->getDevice()->getSite()->getName(),
                    'device_name' => $result->getDevice()->getName(),
                ];
                $records[] = $record;
            }
        }

        $logoPath = "data/logo/iwk-logo-trans.png";
        $view = new ViewModel([
            'logoPath'  => $logoPath,
            'data'      => $records,
            'date'      => (new \DateTime('now'))->format('Y-m-d'),
        ]);

        $view->setTemplate('pdf/logs.phtml');
        $html = $this->viewRenderer->render($view);
        $this->sendToPdf($html, (new \DateTime('now'))->format('Y-m-d'));

        return $view;
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
        $dompdf->stream('queue-log-report-'.$date);
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
