<?php

namespace Berita\V1\Service;

use Berita\V1\KomentarEvent;
use Zend\InputFilter\InputFilter;
use Zend\EventManager\EventManagerAwareTrait;

class Komentar
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
        $event = new KomentarEvent();
        $event->setInput($input);
        $event->setName(KomentarEvent::EVENT_CREATE_KOMENTAR);
        $create = $this->getEventManager()->triggerEvent($event);

        if ($create->stopped()) {
            $event->setName(KomentarEvent::EVENT_CREATE_KOMENTAR_ERROR);
            $event->setException($create->last());
            $this->getEventManager()->triggerEvent($event);
            throw $event->getException();
        } else {
            $event->setName(KomentarEvent::EVENT_CREATE_KOMENTAR_SUCCESS);
            $this->getEventManager()->triggerEvent($event);
            return $event->getKomentar();
        }
    }

    /**
     * @param  \Berita\Entity\Komentar  $entity
     * @param  \Zend\InputFilter\InputFilter  $input
     * @throws \Exception
     * @return \Berita\Entity\Komentar
     */
    public function update($entity, InputFilter $input)
    {
        $event = new KomentarEvent();
        $event->setKomentar($entity);
        $event->setInput($input);
        $event->setName(KomentarEvent::EVENT_UPDATE_KOMENTAR);
        $update = $this->getEventManager()->triggerEvent($event);

        if ($update->stopped()) {
            $event->setName(KomentarEvent::EVENT_UPDATE_KOMENTAR_ERROR);
            $event->setException($update->last());
            $this->getEventManager()->triggerEvent($event);
            throw $event->getException();
        } else {
            $event->setName(KomentarEvent::EVENT_UPDATE_KOMENTAR_SUCCESS);
            $this->getEventManager()->triggerEvent($event);
            return $event->getKomentar();
        }
    }

    /**
     * @param  \Berita\Entity\Komentar  $entity
     * @throws \Exception
     * @return void
     */
    public function delete($entity)
    {
        $event = new KomentarEvent();
        $event->setKomentar($entity);
        $event->setName(KomentarEvent::EVENT_DELETE_KOMENTAR);
        $delete = $this->getEventManager()->triggerEvent($event);

        if ($delete->stopped()) {
            $event->setName(KomentarEvent::EVENT_DELETE_KOMENTAR_ERROR);
            $event->setException($delete->last());
            $this->getEventManager()->triggerEvent($event);
            throw $event->getException();
        } else {
            $event->setName(KomentarEvent::EVENT_DELETE_KOMENTAR_SUCCESS);
            $this->getEventManager()->triggerEvent($event);
            return true;
        }
    }
}
