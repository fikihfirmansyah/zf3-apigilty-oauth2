<?php

namespace Forum\V1;

use Forum\Entity\Thread;
use Zend\EventManager\Event;
use Zend\InputFilter\InputFilter;

class ThreadEvent extends Event
{
    public const EVENT_CREATE_THREAD         = 'create.thread';
    public const EVENT_CREATE_THREAD_ERROR   = 'create.thread.error';
    public const EVENT_CREATE_THREAD_SUCCESS = 'create.thread.success';

    public const EVENT_UPDATE_THREAD        = 'update.thread';
    public const EVENT_UPDATE_THREAD_ERROR   = 'update.thread.error';
    public const EVENT_UPDATE_THREAD_SUCCESS = 'update.thread.success';

    public const EVENT_DELETE_THREAD        = 'delete.thread';
    public const EVENT_DELETE_THREAD_ERROR   = 'delete.thread.error';
    public const EVENT_DELETE_THREAD_SUCCESS = 'delete.thread.success';

    /**
     * @var \Zend\InputFilter\InputFilterInterface
     */
    protected $input;

    /**
     * @var \Forum\Entity\Thread
     */
    protected $thread;

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
     * @param  \Forum\Entity\Thread  $thread
     * @return void
     */
    public function setThread(Thread $thread)
    {
        $this->thread = $thread;
    }

    /**
     * @return \Forum\Entity\Thread
     */
    public function getThread()
    {
        return $this->thread;
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
