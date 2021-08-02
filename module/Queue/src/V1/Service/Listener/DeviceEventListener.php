<?php

namespace Queue\V1\Service\Listener;

use Psr\Log\LoggerAwareTrait;
use Queue\Entity\Device as DeviceEntity;
use Queue\Mapper\Device as DeviceMapper;
use Queue\V1\DeviceEvent;
use Zend\EventManager\EventManagerAwareTrait;
use Zend\EventManager\EventManagerInterface;
use Zend\EventManager\ListenerAggregateInterface;
use Zend\EventManager\ListenerAggregateTrait;
use Zend\InputFilter\InputFilter;
use Zend\Log\Exception\RuntimeException;

class DeviceEventListener implements ListenerAggregateInterface
{
    use ListenerAggregateTrait;
    use EventManagerAwareTrait;
    use LoggerAwareTrait;

    protected $config;
    protected $queueDeviceMapper;
    protected $queeuDeviceHydrator;
    protected $logger;

    /**
     * @param  mixed  $config
     * @param  \Queue\Mapper\Device  $queueDeviceMapper
     * @param  mixed  $queueDeviceHydrator
     * @param  mixed  $logger
     */
    public function __construct(
        $config,
        DeviceMapper $queueDeviceMapper,
        $queueDeviceHydrator,
        $logger
    ) {
        $this->config = $config;
        $this->queueDeviceMapper = $queueDeviceMapper;
        $this->queeuDeviceHydrator = $queueDeviceHydrator;
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
            DeviceEvent::EVENT_CREATE_QUEUE_DEVICE,
            [$this, 'createQueueDevice'],
            500
        );
        $this->listeners[] = $events->attach(
            DeviceEvent::EVENT_UPDATE_QUEUE_DEVICE,
            [$this, 'updateQueueDevice'],
            500
        );
        $this->listeners[] = $events->attach(
            DeviceEvent::EVENT_DELETE_QUEUE_DEVICE,
            [$this, 'deleteQueueDevice'],
            500
        );
    }

    /**
     * @param  \Queue\V1\DeviceEvent  $event
     * @return \Exception|null
     */
    public function createQueueDevice(DeviceEvent $event)
    {
        try {
            if(!($event->getInput() instanceof InputFilter))
                throw new \InvalidArgumentException('Input filter not set');

            $bodyRequest = $event->getInput()->getValues();
            $hydratedEntity = $this->queeuDeviceHydrator
                ->hydrate(
                    $bodyRequest,
                    new DeviceEntity()
                );

            $hydratedEntity->setCreatedAt(new \DateTime('now'));
            $hydratedEntity->setUpdatedAt(new \DateTime('now'));
            $entity = $this->queueDeviceMapper->save($hydratedEntity);
            if(!$entity instanceof DeviceEntity)
                throw new \Exception('$entity is not an instance of DeviceEntity');

            $event->setDevice($entity);
            $this->logger->log(
                \Psr\Log\LogLevel::INFO,
                "{function} : New queue device data {uuid} created successfully",
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
     * @param  \Queue\V1\DeviceEvent  $event
     * @return \Exception|null
     */
    public function updateQueueDevice(DeviceEvent $event)
    {
        try {
            if(!($event->getInput() instanceof InputFilter))
                throw new \InvalidArgumentException('Input filter not set');

            $bodyRequest = $event->getInput()->getValues();
            $currentEntity = $event->getDevice();
            $currentEntity->setUpdatedAt(new \DateTime('now'));
            $hydratedEntity = $this->queeuDeviceHydrator
                ->hydrate(
                    $bodyRequest,
                    $currentEntity
                );

            $entity = $this->queueDeviceMapper->save($hydratedEntity);
            if(!$entity instanceof DeviceEntity)
                throw new \Exception('$entity is not an instance of DeviceEntity');

            $event->setDevice($entity);
            $this->logger->log(
                \Psr\Log\LogLevel::INFO,
                "{function} : Queue Device data {uuid} updated successfully",
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
     * @param  \Queue\V1\DeviceEvent  $event
     * @return \Exception|null
     */
    public function deleteQueueDevice(DeviceEvent $event)
    {
        try {
            $targetEntity = $event->getDevice();
            $this->queueDeviceMapper->delete($targetEntity);

            $this->logger->log(
                \Psr\Log\LogLevel::INFO,
                "{function} : Queue Device data {uuid} deleted successfully",
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
