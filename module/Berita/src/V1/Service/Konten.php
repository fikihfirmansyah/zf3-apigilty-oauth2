<?php

namespace Berita\V1\Service;

use Berita\V1\KontenEvent;
use Zend\InputFilter\InputFilter;
use Zend\EventManager\EventManagerAwareTrait;

class Konten
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
        $event = new KontenEvent();
        $event->setInput($input);
        $event->setName(KontenEvent::EVENT_CREATE_KONTEN);
        $create = $this->getEventManager()->triggerEvent($event);

        if ($create->stopped()) {
            $event->setName(KontenEvent::EVENT_CREATE_KONTEN_ERROR);
            $event->setException($create->last());
            $this->getEventManager()->triggerEvent($event);
            throw $event->getException();
        } else {
            $event->setName(KontenEvent::EVENT_CREATE_KONTEN_SUCCESS);
            $this->getEventManager()->triggerEvent($event);
            return $event->getKonten();
        }
    }

    /**
     * @param  \Berita\Entity\Konten  $entity
     * @param  \Zend\InputFilter\InputFilter  $input
     * @throws \Exception
     * @return \Berita\Entity\Konten
     */
    public function update($entity, InputFilter $input)
    {
        $event = new KontenEvent();
        $event->setKonten($entity);
        $event->setInput($input);
        $event->setName(KontenEvent::EVENT_UPDATE_KONTEN);
        $update = $this->getEventManager()->triggerEvent($event);

        if ($update->stopped()) {
            $event->setName(KontenEvent::EVENT_UPDATE_KONTEN_ERROR);
            $event->setException($update->last());
            $this->getEventManager()->triggerEvent($event);
            throw $event->getException();
        } else {
            $event->setName(KontenEvent::EVENT_UPDATE_KONTEN_SUCCESS);
            $this->getEventManager()->triggerEvent($event);
            return $event->getKonten();
        }
    }

    /**
     * @param  \Berita\Entity\Konten  $entity
     * @throws \Exception
     * @return void
     */
    public function delete($entity)
    {
        $event = new KontenEvent();
        $event->setKonten($entity);
        $event->setName(KontenEvent::EVENT_DELETE_KONTEN);
        $delete = $this->getEventManager()->triggerEvent($event);

        if ($delete->stopped()) {
            $event->setName(KontenEvent::EVENT_DELETE_KONTEN_ERROR);
            $event->setException($delete->last());
            $this->getEventManager()->triggerEvent($event);
            throw $event->getException();
        } else {
            $event->setName(KontenEvent::EVENT_DELETE_KONTEN_SUCCESS);
            $this->getEventManager()->triggerEvent($event);
            return true;
        }
    }
}
