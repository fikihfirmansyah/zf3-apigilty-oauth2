<?php

namespace News\V1\Service;

use News\V1\ContentsEvent;
use Zend\InputFilter\InputFilter;
use Zend\EventManager\EventManagerAwareTrait;

class Contents
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
        $event = new ContentsEvent();
        $event->setInput($input);
        $event->setName(ContentsEvent::EVENT_CREATE_CONTENTS);
        $create = $this->getEventManager()->triggerEvent($event);

        if ($create->stopped()) {
            $event->setName(ContentsEvent::EVENT_CREATE_CONTENTS_ERROR);
            $event->setException($create->last());
            $this->getEventManager()->triggerEvent($event);
            throw $event->getException();
        } else {
            $event->setName(ContentsEvent::EVENT_CREATE_CONTENTS_SUCCESS);
            $this->getEventManager()->triggerEvent($event);
            return $event->getContents();
        }
    }

    /**
     * @param  \News\Entity\Contents  $entity
     * @param  \Zend\InputFilter\InputFilter  $input
     * @throws \Exception
     * @return \News\Entity\Contents
     */
    public function update($entity, InputFilter $input)
    {
        $event = new ContentsEvent();
        $event->setContents($entity);
        $event->setInput($input);
        $event->setName(ContentsEvent::EVENT_UPDATE_CONTENTS);
        $update = $this->getEventManager()->triggerEvent($event);

        if ($update->stopped()) {
            $event->setName(ContentsEvent::EVENT_UPDATE_CONTENTS_ERROR);
            $event->setException($update->last());
            $this->getEventManager()->triggerEvent($event);
            throw $event->getException();
        } else {
            $event->setName(ContentsEvent::EVENT_UPDATE_CONTENTS_SUCCESS);
            $this->getEventManager()->triggerEvent($event);
            return $event->getContents();
        }
    }

    /**
     * @param  \News\Entity\Contents  $entity
     * @throws \Exception
     * @return void
     */
    public function delete($entity)
    {
        $event = new ContentsEvent();
        $event->setContents($entity);
        $event->setName(ContentsEvent::EVENT_DELETE_CONTENTS);
        $delete = $this->getEventManager()->triggerEvent($event);

        if ($delete->stopped()) {
            $event->setName(ContentsEvent::EVENT_DELETE_CONTENTS_ERROR);
            $event->setException($delete->last());
            $this->getEventManager()->triggerEvent($event);
            throw $event->getException();
        } else {
            $event->setName(ContentsEvent::EVENT_DELETE_CONTENTS_SUCCESS);
            $this->getEventManager()->triggerEvent($event);
            return true;
        }
    }
}
