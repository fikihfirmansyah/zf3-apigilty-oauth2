<?php

namespace Queue\V1;

use Queue\Entity\Site;
use Zend\EventManager\Event;
use Zend\InputFilter\InputFilter;

class SiteEvent extends Event
{
    public const EVENT_CREATE_QUEUE_SITE         = 'create.queue.site';
    public const EVENT_CREATE_QUEUE_SITE_ERROR   = 'create.queue.site.error';
    public const EVENT_CREATE_QUEUE_SITE_SUCCESS = 'create.queue.site.success';

    public const EVENT_UPDATE_QUEUE_SITE         = 'update.queue.site';
    public const EVENT_UPDATE_QUEUE_SITE_ERROR   = 'update.queue.site.error';
    public const EVENT_UPDATE_QUEUE_SITE_SUCCESS = 'update.queue.site.success';

    public const EVENT_DELETE_QUEUE_SITE         = 'delete.queue.site';
    public const EVENT_DELETE_QUEUE_SITE_ERROR   = 'delete.queue.site.error';
    public const EVENT_DELETE_QUEUE_SITE_SUCCESS = 'delete.queue.site.success';

    /**
     * @var \Zend\InputFilter\InputFilterInterface
     */
    protected $input;

    /**
     * @var \Queue\Entity\Site
     */
    protected $site;

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
     * @param  \Queue\Entity\Site  $site
     * @return void
     */
    public function setSite(Site $site)
    {
        $this->site = $site;
    }

    /**
     * @return \Queue\Entity\Site
     */
    public function getSite()
    {
        return $this->site;
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
