<?php

namespace Queue\V1\Service;

use DateTime;
use Queue\Entity\Log as LogEntity;
use Queue\V1\LogEvent;
use Zend\InputFilter\InputFilter;
use Zend\EventManager\EventManagerAwareTrait;

class Log
{
    use EventManagerAwareTrait;

    /**
     *
     */
    public function __construct()
    {

    }

    /**
     * @param  \Zend\InputFilter\InputFilter  $input
     * @throws \Exception
     * @return void
     */
    public function save(InputFilter $input)
    {
        $event = new LogEvent();
        $event->setInput($input);
        $event->setName(LogEvent::EVENT_CREATE_QUEUE_LOG);
        $create = $this->getEventManager()->triggerEvent($event);

        if($create->stopped()) {
            $event->setName(LogEvent::EVENT_CREATE_QUEUE_LOG_ERROR);
            $event->setException($create->last());
            $this->getEventManager()->triggerEvent($event);
            throw $event->getException();
        } else {
            $event->setName(LogEvent::EVENT_CREATE_QUEUE_LOG_SUCCESS);
            $this->getEventManager()->triggerEvent($event);
            return $event->getLog();
        }
    }

    /**
     * @param  \Queue\Entity\Log  $entity
     * @param  \Zend\InputFilter\InputFilter  $input
     * @throws \Exception
     * @return \Queue\Entity\Log
     */
    public function update($entity, InputFilter $input)
    {
        $event = new LogEvent();
        $event->setLog($entity);
        $event->setInput($input);
        $event->setName(LogEvent::EVENT_UPDATE_QUEUE_LOG);
        $update = $this->getEventManager()->triggerEvent($event);

        if($update->stopped()) {
            $event->setName(LogEvent::EVENT_UPDATE_QUEUE_LOG_ERROR);
            $event->setException($update->last());
            $this->getEventManager()->triggerEvent($event);
            throw $event->getException();
        } else {
            $event->setName(LogEvent::EVENT_UPDATE_QUEUE_LOG_SUCCESS);
            $this->getEventManager()->triggerEvent($event);
            return $event->getLog();
        }
    }

    /**
     * @param  \Queue\Entity\Log  $entity
     * @throws \Exception
     * @return void
     */
    public function delete($entity)
    {
        $event = new LogEvent();
        $event->setLog($entity);
        $event->setName(LogEvent::EVENT_DELETE_QUEUE_LOG);
        $delete = $this->getEventManager()->triggerEvent($event);

        if($delete->stopped()) {
            $event->setName(LogEvent::EVENT_DELETE_QUEUE_LOG_ERROR);
            $event->setException($delete->last());
            $this->getEventManager()->triggerEvent($event);
            throw $event->getException();
        } else {
            $event->setName(LogEvent::EVENT_DELETE_QUEUE_LOG_SUCCESS);
            $this->getEventManager()->triggerEvent($event);
            return true;
        }
    }

    public function exportQueueLog($queryBuilder)
    {
        $tmpfname = tempnam('/tmp', 'report-ot-');
        $results  = $queryBuilder->getResult();
        $record   = [];
        $file     = fopen($tmpfname, 'w');
        $headers = [
            'Queue No.',
            'Counter',
            'Reserved Time',
            'Called Time',
            'End Time',
            'Waiting Duration (minutes)',
            'Processing Duration (minutes)',
            'Site',
            'Device',
        ];
        fputcsv($file, $headers);

        foreach ($results as $result) {
            if($result instanceof LogEntity) {
                $record = [
                    $result->getNumber(),
                    $result->getCounterNumber(),
                    $this->formatDateTimeMaybeNull($result->getReservedTime()),
                    $this->formatDateTimeMaybeNull($result->getCalledTime()),
                    $this->formatDateTimeMaybeNull($result->getEndTime()),
                    $result->getWaitingTime(),
                    $result->getProcessingTime(),
                    $result->getDevice()->getSite()->getName(),
                    $result->getDevice()->getName(),
                ];
                fputcsv($file, $record);
            }
        }

        fclose($file);

        return $tmpfname;
    }

    /**
     * @param  \DateTime|null  $input
     * @return string
     */
    protected function formatDateTimeMaybeNull($input)
    {
        if($input !== null && $input instanceof DateTime)
            return $input->format('Y-m-d');
        return '';
    }
}
