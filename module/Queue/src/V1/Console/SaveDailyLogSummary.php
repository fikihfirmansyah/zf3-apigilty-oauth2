<?php
namespace Queue\V1\Console;

use ZF\Console\Route;
use Zend\Console\Adapter\AdapterInterface;
use Psr\Container\ContainerInterface;
use Psr\Log\LoggerAwareTrait;
use Queue\Entity\LogDailySummary;
use Zend\Console\ColorInterface;

class SaveDailyLogSummary
{
    use LoggerAwareTrait;

    /**
     * @var \Queue\Mapper\Device
     */
    protected $deviceMapper;

    /**
     * @var \Queue\Mapper\Log
     */
    protected $queueLogMapper;

    /**
     * @var \Queue\Mapper\LogDailySummary
     */
    protected $queueLogDailySummaryMapper;

    /**
     * @param  \Psr\Container\ContainerInterface  $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->deviceMapper = $container->get(\Queue\Mapper\Device::class);
        $this->queueLogMapper = $container->get(\Queue\Mapper\Log::class);
        $this->queueLogDailySummaryMapper = $container->get(\Queue\Mapper\LogDailySummary::class);
    }

    /**
     * @param  \ZF\Console\Route  $route
     * @param  \Zend\Console\Adapter\AdapterInterface  $console
     * @return void
     */
    public function __invoke(Route $route, AdapterInterface $console)
    {
        try {
            $console->writeLine("Saving today's daily log summary.", ColorInterface::YELLOW);

            $dateParam = $route->getMatchedParam('date', 'now');
            $dateString = (new \DateTime($dateParam))->format('Y-m-d');
            $date = new \DateTime($dateString);
            $todaySummaries = $this->queueLogMapper
                                ->getStatsPerDevice(['date' => $dateString])
                                ->getResult();

            foreach($todaySummaries as $todaySummary) {
                $dailySummary = $this->queueLogDailySummaryMapper
                    ->fetchOneBy([
                        'device'    => $todaySummary['deviceUuid'],
                        'date'      => $date,
                    ]);

                if(!$dailySummary) {
                    $device = $this->deviceMapper
                        ->fetchOneBy(['uuid' => $todaySummary['deviceUuid']]);
                    $dailySummary = new LogDailySummary();
                    $dailySummary->setDevice($device);
                    $dailySummary->setDate($date);
                    $dailySummary->setCreatedAt(new \DateTime());
                }

                if($dailySummary instanceof LogDailySummary) {
                    $dailySummary->setUpdatedAt(new \DateTime());
                    $dailySummary->setCounterNumber((string)$todaySummary['counterNumber']);
                    $dailySummary->setTotalQueue((int)$todaySummary['totalQueue']);
                    $dailySummary->setAvgWaitingTime((float)$todaySummary['avgWaitingTime']);
                    $dailySummary->setAvgProcessingTime((float)$todaySummary['avgProcessingTime']);

                    $this->queueLogDailySummaryMapper->save($dailySummary);

                    $console->write("Saved summary for device: ", ColorInterface::YELLOW);
                    $console->writeLine($todaySummary['deviceUuid'], ColorInterface::WHITE);
                }
            }

            $console->writeLine("Saved today's daily log summary", ColorInterface::GREEN);
        } catch(\Exception $ex) {
            $console->writeLine($ex->getMessage(), ColorInterface::RED);
        }
    }
}
