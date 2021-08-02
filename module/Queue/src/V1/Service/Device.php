<?php

namespace Queue\V1\Service;

use Queue\V1\DeviceEvent;
use Zend\InputFilter\InputFilter;
use Zend\EventManager\EventManagerAwareTrait;

class Device
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
        $event = new DeviceEvent();
        $event->setInput($input);
        $event->setName(DeviceEvent::EVENT_CREATE_QUEUE_DEVICE);
        $create = $this->getEventManager()->triggerEvent($event);

        if($create->stopped()) {
            $event->setName(DeviceEvent::EVENT_CREATE_QUEUE_DEVICE_ERROR);
            $event->setException($create->last());
            $this->getEventManager()->triggerEvent($event);
            throw $event->getException();
        } else {
            $event->setName(DeviceEvent::EVENT_CREATE_QUEUE_DEVICE_SUCCESS);
            $this->getEventManager()->triggerEvent($event);
            return $event->getDevice();
        }
    }

    /**
     * @param  \Queue\Entity\Device  $entity
     * @param  \Zend\InputFilter\InputFilter  $input
     * @throws \Exception
     * @return \Queue\Entity\Device
     */
    public function update($entity, InputFilter $input)
    {
        $event = new DeviceEvent();
        $event->setDevice($entity);
        $event->setInput($input);
        $event->setName(DeviceEvent::EVENT_UPDATE_QUEUE_DEVICE);
        $update = $this->getEventManager()->triggerEvent($event);

        if($update->stopped()) {
            $event->setName(DeviceEvent::EVENT_UPDATE_QUEUE_DEVICE_ERROR);
            $event->setException($update->last());
            $this->getEventManager()->triggerEvent($event);
            throw $event->getException();
        } else {
            $event->setName(DeviceEvent::EVENT_UPDATE_QUEUE_DEVICE_SUCCESS);
            $this->getEventManager()->triggerEvent($event);
            return $event->getDevice();
        }
    }

    /**
     * @param  \Queue\Entity\Device  $entity
     * @throws \Exception
     * @return void
     */
    public function delete($entity)
    {
        $event = new DeviceEvent();
        $event->setDevice($entity);
        $event->setName(DeviceEvent::EVENT_DELETE_QUEUE_DEVICE);
        $delete = $this->getEventManager()->triggerEvent($event);

        if($delete->stopped()) {
            $event->setName(DeviceEvent::EVENT_DELETE_QUEUE_DEVICE_ERROR);
            $event->setException($delete->last());
            $this->getEventManager()->triggerEvent($event);
            throw $event->getException();
        } else {
            $event->setName(DeviceEvent::EVENT_DELETE_QUEUE_DEVICE_SUCCESS);
            $this->getEventManager()->triggerEvent($event);
            return true;
        }
    }
}
