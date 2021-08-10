<?php

namespace Forum\V1\Service;

use Forum\V1\ThreadEvent;
use Zend\InputFilter\InputFilter;
use Zend\EventManager\EventManagerAwareTrait;

class Thread
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
        $event = new ThreadEvent();
        $event->setInput($input);
        $event->setName(ThreadEvent::EVENT_CREATE_THREAD);
        $create = $this->getEventManager()->triggerEvent($event);

        if ($create->stopped()) {
            $event->setName(ThreadEvent::EVENT_CREATE_THREAD_ERROR);
            $event->setException($create->last());
            $this->getEventManager()->triggerEvent($event);
            throw $event->getException();
        } else {
            $event->setName(ThreadEvent::EVENT_CREATE_THREAD_SUCCESS);
            $this->getEventManager()->triggerEvent($event);
            return $event->getThread();
        }
    }

    /**
     * @param  \Forum\Entity\Thread  $entity
     * @param  \Zend\InputFilter\InputFilter  $input
     * @throws \Exception
     * @return \Forum\Entity\Thread
     */
    public function update($entity, InputFilter $input)
    {
        $event = new ThreadEvent();
        $event->setThread($entity);
        $event->setInput($input);
        $event->setName(ThreadEvent::EVENT_UPDATE_THREAD);
        $update = $this->getEventManager()->triggerEvent($event);

        if ($update->stopped()) {
            $event->setName(ThreadEvent::EVENT_UPDATE_THREAD_ERROR);
            $event->setException($update->last());
            $this->getEventManager()->triggerEvent($event);
            throw $event->getException();
        } else {
            $event->setName(ThreadEvent::EVENT_UPDATE_THREAD_SUCCESS);
            $this->getEventManager()->triggerEvent($event);
            return $event->getThread();
        }
    }

    /**
     * @param  \Forum\Entity\Thread  $entity
     * @throws \Exception
     * @return void
     */
    public function delete($entity)
    {
        $event = new ThreadEvent();
        $event->setThread($entity);
        $event->setName(ThreadEvent::EVENT_DELETE_THREAD);
        $delete = $this->getEventManager()->triggerEvent($event);

        if ($delete->stopped()) {
            $event->setName(ThreadEvent::EVENT_DELETE_THREAD_ERROR);
            $event->setException($delete->last());
            $this->getEventManager()->triggerEvent($event);
            throw $event->getException();
        } else {
            $event->setName(ThreadEvent::EVENT_DELETE_THREAD_SUCCESS);
            $this->getEventManager()->triggerEvent($event);
            return true;
        }
    }
}
