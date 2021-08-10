<?php

namespace Forum\V1;

use Forum\Entity\ReplyNested;
use Zend\EventManager\Event;
use Zend\InputFilter\InputFilter;

class ReplyNestedEvent extends Event
{
    public const EVENT_CREATE_REPLY_NESTED         = 'create.reply.nested';
    public const EVENT_CREATE_REPLY_NESTED_ERROR   = 'create.reply.nested.error';
    public const EVENT_CREATE_REPLY_NESTED_SUCCESS = 'create.reply.nested.success';

    public const EVENT_UPDATE_REPLY_NESTED        = 'update.reply.nested';
    public const EVENT_UPDATE_REPLY_NESTED_ERROR   = 'update.reply.nested.error';
    public const EVENT_UPDATE_REPLY_NESTED_SUCCESS = 'update.reply.nested.success';

    public const EVENT_DELETE_REPLY_NESTED        = 'delete.reply.nested';
    public const EVENT_DELETE_REPLY_NESTED_ERROR   = 'delete.reply.nested.error';
    public const EVENT_DELETE_REPLY_NESTED_SUCCESS = 'delete.reply.nested.success';

    /**
     * @var \Zend\InputFilter\InputFilterInterface
     */
    protected $input;

    /**
     * @var \Forum\Entity\ReplyNested
     */
    protected $replyNested;

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
     * @param  \Forum\Entity\ReplyNested  $replyNested
     * @return void
     */
    public function setReplyNested(ReplyNested $replyNested)
    {
        $this->replyNested = $replyNested;
    }

    /**
     * @return \Forum\Entity\ReplyNested
     */
    public function getReplyNested()
    {
        return $this->replyNested;
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
