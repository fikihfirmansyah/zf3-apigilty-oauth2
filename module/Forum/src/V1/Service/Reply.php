<?php

namespace Forum\V1\Service;

use Forum\V1\ReplyEvent;
use Zend\InputFilter\InputFilter;
use Zend\EventManager\EventManagerAwareTrait;

class Reply
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
        $event = new ReplyEvent();
        $event->setInput($input);
        $event->setName(ReplyEvent::EVENT_CREATE_REPLY);
        $create = $this->getEventManager()->triggerEvent($event);

        if ($create->stopped()) {
            $event->setName(ReplyEvent::EVENT_CREATE_REPLY_ERROR);
            $event->setException($create->last());
            $this->getEventManager()->triggerEvent($event);
            throw $event->getException();
        } else {
            $event->setName(ReplyEvent::EVENT_CREATE_REPLY_SUCCESS);
            $this->getEventManager()->triggerEvent($event);
            return $event->getReply();
        }
    }

    /**
     * @param  \Forum\Entity\Reply  $entity
     * @param  \Zend\InputFilter\InputFilter  $input
     * @throws \Exception
     * @return \Forum\Entity\Reply
     */
    public function update($entity, InputFilter $input)
    {
        $event = new ReplyEvent();
        $event->setReply($entity);
        $event->setInput($input);
        $event->setName(ReplyEvent::EVENT_UPDATE_REPLY);
        $update = $this->getEventManager()->triggerEvent($event);

        if ($update->stopped()) {
            $event->setName(ReplyEvent::EVENT_UPDATE_REPLY_ERROR);
            $event->setException($update->last());
            $this->getEventManager()->triggerEvent($event);
            throw $event->getException();
        } else {
            $event->setName(ReplyEvent::EVENT_UPDATE_REPLY_SUCCESS);
            $this->getEventManager()->triggerEvent($event);
            return $event->getReply();
        }
    }

    /**
     * @param  \Forum\Entity\Reply  $entity
     * @throws \Exception
     * @return void
     */
    public function delete($entity)
    {
        $event = new ReplyEvent();
        $event->setReply($entity);
        $event->setName(ReplyEvent::EVENT_DELETE_REPLY);
        $delete = $this->getEventManager()->triggerEvent($event);

        if ($delete->stopped()) {
            $event->setName(ReplyEvent::EVENT_DELETE_REPLY_ERROR);
            $event->setException($delete->last());
            $this->getEventManager()->triggerEvent($event);
            throw $event->getException();
        } else {
            $event->setName(ReplyEvent::EVENT_DELETE_REPLY_SUCCESS);
            $this->getEventManager()->triggerEvent($event);
            return true;
        }
    }
}
