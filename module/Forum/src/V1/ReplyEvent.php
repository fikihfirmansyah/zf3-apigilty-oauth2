<?php

namespace Forum\V1;

use Forum\Entity\Reply;
use Zend\EventManager\Event;
use Zend\InputFilter\InputFilter;

class ReplyEvent extends Event
{
    public const EVENT_CREATE_REPLY         = 'create.reply';
    public const EVENT_CREATE_REPLY_ERROR   = 'create.reply.error';
    public const EVENT_CREATE_REPLY_SUCCESS = 'create.reply.success';

    public const EVENT_UPDATE_REPLY        = 'update.reply';
    public const EVENT_UPDATE_REPLY_ERROR   = 'update.reply.error';
    public const EVENT_UPDATE_REPLY_SUCCESS = 'update.reply.success';

    public const EVENT_DELETE_REPLY        = 'delete.reply';
    public const EVENT_DELETE_REPLY_ERROR   = 'delete.reply.error';
    public const EVENT_DELETE_REPLY_SUCCESS = 'delete.reply.success';

    /**
     * @var \Zend\InputFilter\InputFilterInterface
     */
    protected $input;

    /**
     * @var \Forum\Entity\Reply
     */
    protected $reply;

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
     * @param  \Forum\Entity\Reply  $reply
     * @return void
     */
    public function setReply(Reply $reply)
    {
        $this->reply = $reply;
    }

    /**
     * @return \Forum\Entity\Reply
     */
    public function getReply()
    {
        return $this->reply;
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
