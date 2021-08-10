<?php

namespace Forum\V1\Service;

use Forum\V1\ReplyNestedEvent;
use Zend\InputFilter\InputFilter;
use Zend\EventManager\EventManagerAwareTrait;

class ReplyNested
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
        $event = new ReplyNestedEvent();
        $event->setInput($input);
        $event->setName(ReplyNestedEvent::EVENT_CREATE_REPLY_NESTED);
        $create = $this->getEventManager()->triggerEvent($event);

        if ($create->stopped()) {
            $event->setName(ReplyNestedEvent::EVENT_CREATE_REPLY_NESTED_ERROR);
            $event->setException($create->last());
            $this->getEventManager()->triggerEvent($event);
            throw $event->getException();
        } else {
            $event->setName(ReplyNestedEvent::EVENT_CREATE_REPLY_NESTED_SUCCESS);
            $this->getEventManager()->triggerEvent($event);
            return $event->getReplyNested();
        }
    }

    /**
     * @param  \Forum\Entity\ReplyNested  $entity
     * @param  \Zend\InputFilter\InputFilter  $input
     * @throws \Exception
     * @return \Forum\Entity\ReplyNested
     */
    public function update($entity, InputFilter $input)
    {
        $event = new ReplyNestedEvent();
        $event->setReplyNested($entity);
        $event->setInput($input);
        $event->setName(ReplyNestedEvent::EVENT_UPDATE_REPLY_NESTED);
        $update = $this->getEventManager()->triggerEvent($event);

        if ($update->stopped()) {
            $event->setName(ReplyNestedEvent::EVENT_UPDATE_REPLY_NESTED_ERROR);
            $event->setException($update->last());
            $this->getEventManager()->triggerEvent($event);
            throw $event->getException();
        } else {
            $event->setName(ReplyNestedEvent::EVENT_UPDATE_REPLY_NESTED_SUCCESS);
            $this->getEventManager()->triggerEvent($event);
            return $event->getReplyNested();
        }
    }

    /**
     * @param  \Forum\Entity\ReplyNested  $entity
     * @throws \Exception
     * @return void
     */
    public function delete($entity)
    {
        $event = new ReplyNestedEvent();
        $event->setReplyNested($entity);
        $event->setName(ReplyNestedEvent::EVENT_DELETE_REPLY_NESTED);
        $delete = $this->getEventManager()->triggerEvent($event);

        if ($delete->stopped()) {
            $event->setName(ReplyNestedEvent::EVENT_DELETE_REPLY_NESTED_ERROR);
            $event->setException($delete->last());
            $this->getEventManager()->triggerEvent($event);
            throw $event->getException();
        } else {
            $event->setName(ReplyNestedEvent::EVENT_DELETE_REPLY_NESTED_SUCCESS);
            $this->getEventManager()->triggerEvent($event);
            return true;
        }
    }
}
