<?php

namespace Queue\V1;

use Queue\Entity\Device;
use Zend\EventManager\Event;
use Zend\InputFilter\InputFilter;

class DeviceEvent extends Event
{
    public const EVENT_CREATE_QUEUE_DEVICE         = 'create.queue.device';
    public const EVENT_CREATE_QUEUE_DEVICE_ERROR   = 'create.queue.device.error';
    public const EVENT_CREATE_QUEUE_DEVICE_SUCCESS = 'create.queue.device.success';

    public const EVENT_UPDATE_QUEUE_DEVICE         = 'update.queue.device';
    public const EVENT_UPDATE_QUEUE_DEVICE_ERROR   = 'update.queue.device.error';
    public const EVENT_UPDATE_QUEUE_DEVICE_SUCCESS = 'update.queue.device.success';

    public const EVENT_DELETE_QUEUE_DEVICE         = 'delete.queue.device';
    public const EVENT_DELETE_QUEUE_DEVICE_ERROR   = 'delete.queue.device.error';
    public const EVENT_DELETE_QUEUE_DEVICE_SUCCESS = 'delete.queue.device.success';

    /**
     * @var \Zend\InputFilter\InputFilterInterface
     */
    protected $input;

    /**
     * @var \Queue\Entity\Device
     */
    protected $device;

    /**
     * @var \Exception
     */
    protected $exception;

    /**
     * @param  \Zend\InputFilter\InputFilter  $input
     * @return void
     */
    public function setInput(InputFilter $input)
    {
        $this->input = $input;
    }

    /**
     * @return \Zend\InputFilter\InputFilter
     */
    public function getInput()
    {
        return $this->input;
    }

    /**
     * @param  \Queue\Entity\Device  $device
     * @return void
     */
    public function setDevice(Device $device)
    {
        $this->device = $device;
    }

    /**
     * @return \Queue\Entity\Device
     */
    public function getDevice()
    {
        return $this->device;
    }

    /**
     * @param  \Exception  $exception
     * @return void
     */
    public function setException(\Exception $exception)
    {
        $this->exception = $exception;
    }

    /**
     * @return \Exception
     */
    public function getException()
    {
        return $this->exception;
    }
}
