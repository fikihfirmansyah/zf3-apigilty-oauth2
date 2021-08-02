<?php

namespace Queue\V1\Service;

use Queue\V1\SiteEvent;
use Zend\InputFilter\InputFilter;
use Zend\EventManager\EventManagerAwareTrait;

class Site
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
        $event = new SiteEvent();
        $event->setInput($input);
        $event->setName(SiteEvent::EVENT_CREATE_QUEUE_SITE);
        $create = $this->getEventManager()->triggerEvent($event);

        if($create->stopped()) {
            $event->setName(SiteEvent::EVENT_CREATE_QUEUE_SITE_ERROR);
            $event->setException($create->last());
            $this->getEventManager()->triggerEvent($event);
            throw $event->getException();
        } else {
            $event->setName(SiteEvent::EVENT_CREATE_QUEUE_SITE_SUCCESS);
            $this->getEventManager()->triggerEvent($event);
            return $event->getSite();
        }
    }

    /**
     * @param  \Queue\Entity\Site  $entity
     * @param  \Zend\InputFilter\InputFilter  $input
     * @throws \Exception
     * @return \Queue\Entity\Site
     */
    public function update($entity, InputFilter $input)
    {
        $event = new SiteEvent();
        $event->setSite($entity);
        $event->setInput($input);
        $event->setName(SiteEvent::EVENT_UPDATE_QUEUE_SITE);
        $update = $this->getEventManager()->triggerEvent($event);

        if($update->stopped()) {
            $event->setName(SiteEvent::EVENT_UPDATE_QUEUE_SITE_ERROR);
            $event->setException($update->last());
            $this->getEventManager()->triggerEvent($event);
            throw $event->getException();
        } else {
            $event->setName(SiteEvent::EVENT_UPDATE_QUEUE_SITE_SUCCESS);
            $this->getEventManager()->triggerEvent($event);
            return $event->getSite();
        }
    }

    /**
     * @param  \Queue\Entity\Site  $entity
     * @throws \Exception
     * @return void
     */
    public function delete($entity)
    {
        $event = new SiteEvent();
        $event->setSite($entity);
        $event->setName(SiteEvent::EVENT_DELETE_QUEUE_SITE);
        $delete = $this->getEventManager()->triggerEvent($event);

        if($delete->stopped()) {
            $event->setName(SiteEvent::EVENT_DELETE_QUEUE_SITE_ERROR);
            $event->setException($delete->last());
            $this->getEventManager()->triggerEvent($event);
            throw $event->getException();
        } else {
            $event->setName(SiteEvent::EVENT_DELETE_QUEUE_SITE_SUCCESS);
            $this->getEventManager()->triggerEvent($event);
            return true;
        }
    }
}
