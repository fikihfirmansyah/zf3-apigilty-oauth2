<?php

namespace News\V1\Service;

use News\V1\CommentsEvent;
use Zend\InputFilter\InputFilter;
use Zend\EventManager\EventManagerAwareTrait;

class Comments
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
        $event = new CommentsEvent();
        $event->setInput($input);
        $event->setName(CommentsEvent::EVENT_CREATE_COMMENTS);
        $create = $this->getEventManager()->triggerEvent($event);

        if ($create->stopped()) {
            $event->setName(CommentsEvent::EVENT_CREATE_COMMENTS_ERROR);
            $event->setException($create->last());
            $this->getEventManager()->triggerEvent($event);
            throw $event->getException();
        } else {
            $event->setName(CommentsEvent::EVENT_CREATE_COMMENTS_SUCCESS);
            $this->getEventManager()->triggerEvent($event);
            return $event->getComments();
        }
    }

    /**
     * @param  \News\Entity\Comments  $entity
     * @param  \Zend\InputFilter\InputFilter  $input
     * @throws \Exception
     * @return \News\Entity\Comments
     */
    public function update($entity, InputFilter $input)
    {
        $event = new CommentsEvent();
        $event->setComments($entity);
        $event->setInput($input);
        $event->setName(CommentsEvent::EVENT_UPDATE_COMMENTS);
        $update = $this->getEventManager()->triggerEvent($event);

        if ($update->stopped()) {
            $event->setName(CommentsEvent::EVENT_UPDATE_COMMENTS_ERROR);
            $event->setException($update->last());
            $this->getEventManager()->triggerEvent($event);
            throw $event->getException();
        } else {
            $event->setName(CommentsEvent::EVENT_UPDATE_COMMENTS_SUCCESS);
            $this->getEventManager()->triggerEvent($event);
            return $event->getComments();
        }
    }

    /**
     * @param  \News\Entity\Comments  $entity
     * @throws \Exception
     * @return void
     */
    public function delete($entity)
    {
        $event = new CommentsEvent();
        $event->setComments($entity);
        $event->setName(CommentsEvent::EVENT_DELETE_COMMENTS);
        $delete = $this->getEventManager()->triggerEvent($event);

        if ($delete->stopped()) {
            $event->setName(CommentsEvent::EVENT_DELETE_COMMENTS_ERROR);
            $event->setException($delete->last());
            $this->getEventManager()->triggerEvent($event);
            throw $event->getException();
        } else {
            $event->setName(CommentsEvent::EVENT_DELETE_COMMENTS_SUCCESS);
            $this->getEventManager()->triggerEvent($event);
            return true;
        }
    }
}
