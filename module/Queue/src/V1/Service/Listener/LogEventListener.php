<?php

namespace Queue\V1\Service\Listener;

use Psr\Log\LoggerAwareTrait;
use Queue\Entity\Log as LogEntity;
use Queue\Mapper\Log as LogMapper;
use Queue\V1\LogEvent;
use Zend\EventManager\EventManagerAwareTrait;
use Zend\EventManager\EventManagerInterface;
use Zend\EventManager\ListenerAggregateInterface;
use Zend\EventManager\ListenerAggregateTrait;
use Zend\InputFilter\InputFilter;
use Zend\Log\Exception\RuntimeException;

class LogEventListener implements ListenerAggregateInterface
{
    use ListenerAggregateTrait;
    use EventManagerAwareTrait;
    use LoggerAwareTrait;

    protected $config;
    protected $queueLogMapper;
    protected $queueLogHydrator;
    protected $logger;

    /**
     * @param  mixed  $config
     * @param  \Queue\Mapper\Log  $queueLogMapper
     * @param  mixed  $queueLogHydrator
     * @param  mixed  $logger
     */
    public function __construct(
        $config,
        LogMapper $queueLogMapper,
        $queueLogHydrator,
        $logger
    ) {
        $this->config = $config;
        $this->queueLogMapper = $queueLogMapper;
        $this->queueLogHydrator = $queueLogHydrator;
        $this->logger = $logger;
    }

    /**
     * @param  \Zend\EventManager\EventManagerInterface  $events
     * @param  int  $priority
     * @return void
     */
    public function attach(EventManagerInterface $events, $priority = 1)
    {
        $this->listeners[] = $events->attach(
            LogEvent::EVENT_CREATE_QUEUE_LOG,
            [$this, 'createQueueLog'],
            500
        );
        $this->listeners[] = $events->attach(
            LogEvent::EVENT_UPDATE_QUEUE_LOG,
            [$this, 'updateQueueLog'],
            500
        );
        $this->listeners[] = $events->attach(
            LogEvent::EVENT_DELETE_QUEUE_LOG,
            [$this, 'deleteQueueLog'],
            500
        );
    }

    /**
     * @param  \Queue\V1\LogEvent  $event
     * @return \Exception|null
     */
    public function createQueueLog(LogEvent $event)
    {
        try {
            if(!($event->getInput() instanceof InputFilter))
                throw new \InvalidArgumentException('Input filter not set');

            $bodyRequest = $event->getInput()->getValues();
            $hydratedEntity = $this->queueLogHydrator
                ->hydrate(
                    $bodyRequest,
                    new LogEntity()
                );

            $hydratedEntity->setCreatedAt(new \DateTime('now'));
            $hydratedEntity->setUpdatedAt(new \DateTime('now'));
            $entity = $this->queueLogMapper->save($hydratedEntity);
            if(!$entity instanceof LogEntity)
                throw new \Exception('$entity is not an instance of LogEntity');

            $event->setLog($entity);
            $this->logger->log(
                \Psr\Log\LogLevel::INFO,
                "{function} : New queue log data {uuid} created successfully",
                [
                    'function'  => __FUNCTION__,
                    'uuid'      => $entity->getUuid(),
                ]
            );
        } catch(RuntimeException $ex) {
            $event->stopPropagation(true);
            $this->logger->log(
                \Psr\Log\LogLevel::ERROR,
                "{function} : Something error !\nError message: {message}",
                [
                    'function'  => __FUNCTION__,
                    'message'   => $ex->getMessage(),
                ]
            );
            return $ex;
        }

        return null;
    }

    /**
     * @param  \Queue\V1\LogEvent  $event
     * @return \Exception|null
     */
    public function updateQueueLog(LogEvent $event)
    {
        try {
            if(!($event->getInput() instanceof InputFilter))
                throw new \InvalidArgumentException('Input filter not set');

            $bodyRequest = $event->getInput()->getValues();
            $currentEntity = $event->getLog();
            $currentEntity->setUpdatedAt(new \DateTime('now'));
            $hydratedEntity = $this->queueLogHydrator
                ->hydrate(
                    $bodyRequest,
                    $currentEntity
                );

            $entity = $this->queueLogMapper->save($hydratedEntity);
            if(!$entity instanceof LogEntity)
                throw new \Exception('$entity is not an instance of Log Entity');

            $event->setLog($entity);
            $this->logger->log(
                \Psr\Log\LogLevel::INFO,
                "{function} : Queue Log data {uuid} updated successfully",
                [
                    'function'  => __FUNCTION__,
                    'uuid'      => $entity->getUuid(),
                ]
            );
        } catch(RuntimeException $ex) {
            $event->stopPropagation(true);
            $this->logger->log(
                \Psr\Log\LogLevel::ERROR,
                "{function} : Something error !\nError message: {message}",
                [
                    'function'  => __FUNCTION__,
                    'message'   => $ex->getMessage(),
                ]
            );
            return $ex;
        }

        return null;
    }

    /**
     * @param  \Queue\V1\LogEvent  $event
     * @return \Exception|null
     */
    public function deleteQueueLog(LogEvent $event)
    {
        try {
            $targetEntity = $event->getLog();
            $this->queueLogMapper->delete($targetEntity);

            $this->logger->log(
                \Psr\Log\LogLevel::INFO,
                "{function} : Queue Log data {uuid} deleted successfully",
                [
                    'function'  => __FUNCTION__,
                    'uuid'      => $targetEntity->getUuid(),
                ]
            );
        } catch(RuntimeException $ex) {
            $event->stopPropagation(true);
            $this->logger->log(
                \Psr\Log\LogLevel::ERROR,
                "{function} : Something error !\nError message: {message}",
                [
                    'function'  => __FUNCTION__,
                    'message'   => $ex->getMessage(),
                ]
            );
            return $ex;
        }

        return null;
    }
}
