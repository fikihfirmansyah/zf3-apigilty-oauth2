<?php

namespace Queue\V1;

use Queue\Entity\Log;
use Zend\EventManager\Event;
use Zend\InputFilter\InputFilter;

class LogEvent extends Event
{
    public const EVENT_CREATE_QUEUE_LOG         = 'create.queue.log';
    public const EVENT_CREATE_QUEUE_LOG_ERROR   = 'create.queue.log.error';
    public const EVENT_CREATE_QUEUE_LOG_SUCCESS = 'create.queue.log.success';

    public const EVENT_UPDATE_QUEUE_LOG         = 'update.queue.log';
    public const EVENT_UPDATE_QUEUE_LOG_ERROR   = 'update.queue.log.error';
    public const EVENT_UPDATE_QUEUE_LOG_SUCCESS = 'update.queue.log.success';

    public const EVENT_DELETE_QUEUE_LOG         = 'delete.queue.log';
    public const EVENT_DELETE_QUEUE_LOG_ERROR   = 'delete.queue.log.error';
    public const EVENT_DELETE_QUEUE_LOG_SUCCESS = 'delete.queue.log.success';

    /**
     * @var \Zend\InputFilter\InputFilterInterface
     */
    protected $input;

    /**
     * @var \Queue\Entity\Log
     */
    protected $log;

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
     * @param  \Queue\Entity\Log  $log
     * @return void
     */
    public function setLog(Log $log)
    {
        $this->log = $log;
    }

    /**
     * @return \Queue\Entity\Log
     */
    public function getLog()
    {
        return $this->log;
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
