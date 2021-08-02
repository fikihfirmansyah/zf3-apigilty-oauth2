<?php

namespace News\V1;

use News\Entity\Comments;
use Zend\EventManager\Event;
use Zend\InputFilter\InputFilter;

class CommentsEvent extends Event
{
    public const EVENT_CREATE_COMMENTS         = 'create.comments';
    public const EVENT_CREATE_COMMENTS_ERROR   = 'create.comments.error';
    public const EVENT_CREATE_COMMENTS_SUCCESS = 'create.comments.success';

    public const EVENT_UPDATE_COMMENTS        = 'update.comments';
    public const EVENT_UPDATE_COMMENTS_ERROR   = 'update.comments.error';
    public const EVENT_UPDATE_COMMENTS_SUCCESS = 'update.comments.success';

    public const EVENT_DELETE_COMMENTS        = 'delete.comments';
    public const EVENT_DELETE_COMMENTS_ERROR   = 'delete.comments.error';
    public const EVENT_DELETE_COMMENTS_SUCCESS = 'delete.comments.success';

    /**
     * @var \Zend\InputFilter\InputFilterInterface
     */
    protected $input;

    /**
     * @var \News\Entity\Comments
     */
    protected $comments;

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
     * @param  \News\Entity\Comments  $comments
     * @return void
     */
    public function setComments(Comments $comments)
    {
        $this->comments = $comments;
    }

    /**
     * @return \News\Entity\Comments
     */
    public function getComments()
    {
        return $this->comments;
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
