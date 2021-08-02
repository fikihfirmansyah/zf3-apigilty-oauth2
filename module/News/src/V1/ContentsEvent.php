<?php

namespace News\V1;

use News\Entity\Contents;
use Zend\EventManager\Event;
use Zend\InputFilter\InputFilter;

class ContentsEvent extends Event
{
    public const EVENT_CREATE_CONTENTS         = 'create.contents';
    public const EVENT_CREATE_CONTENTS_ERROR   = 'create.contents.error';
    public const EVENT_CREATE_CONTENTS_SUCCESS = 'create.contents.success';

    public const EVENT_UPDATE_CONTENTS        = 'update.contents';
    public const EVENT_UPDATE_CONTENTS_ERROR   = 'update.contents.error';
    public const EVENT_UPDATE_CONTENTS_SUCCESS = 'update.contents.success';

    public const EVENT_DELETE_CONTENTS        = 'delete.contents';
    public const EVENT_DELETE_CONTENTS_ERROR   = 'delete.contents.error';
    public const EVENT_DELETE_CONTENTS_SUCCESS = 'delete.contents.success';

    /**
     * @var \Zend\InputFilter\InputFilterInterface
     */
    protected $input;

    /**
     * @var \News\Entity\Contents
     */
    protected $contents;

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
     * @param  \News\Entity\Contents  $contents
     * @return void
     */
    public function setContents(Contents $contents)
    {
        $this->contents = $contents;
    }

    /**
     * @return \News\Entity\Contents
     */
    public function getContents()
    {
        return $this->contents;
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
