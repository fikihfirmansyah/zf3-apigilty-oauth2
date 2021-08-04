<?php

namespace Berita\V1\Service\Listener;

use Psr\Log\LoggerAwareTrait;
use Berita\Entity\Konten as KontenEntity;
use Berita\Mapper\Konten as KontenMapper;
use Berita\V1\KontenEvent;
use Zend\EventManager\EventManagerAwareTrait;
use Zend\EventManager\EventManagerInterface;
use Zend\EventManager\ListenerAggregateInterface;
use Zend\EventManager\ListenerAggregateTrait;
use Zend\InputFilter\InputFilter;
use Zend\Log\Exception\RuntimeException;

class KontenEventListener implements ListenerAggregateInterface
{
    use ListenerAggregateTrait;
    use EventManagerAwareTrait;
    use LoggerAwareTrait;

    protected $config;
    protected $kontenMapper;
    protected $kontenHydrator;
    protected $logger;

    /**
     * @param  mixed  $config
     * @param  \Berita\Mapper\Konten  $kontenMapper
     * @param  mixed  $kontenHydrator
     * @param  mixed  $logger
     */
    public function __construct(
        $config,
        KontenMapper $kontenMapper,
        $kontenHydrator,
        $logger
    ) {
        $this->config = $config;
        $this->kontenMapper = $kontenMapper;
        $this->kontenHydrator = $kontenHydrator;
        $this->logger = $logger;
    }

    /**
     * @param  \Zend\EventManager\EventManagerInterface  $events
     * @param  int  $priority
     * @return void
     */
    public function attach(EventManagerInterface $events, $priority = 1)
    {
        $this->listeners[] = $events->attach(
            KontenEvent::EVENT_CREATE_KONTEN,
            [$this, 'createBeritaKonten'],
            500
        );
        $this->listeners[] = $events->attach(
            KontenEvent::EVENT_UPDATE_KONTEN,
            [$this, 'updateBeritaKonten'],
            500
        );
        $this->listeners[] = $events->attach(
            KontenEvent::EVENT_DELETE_KONTEN,
            [$this, 'deleteBeritaKonten'],
            500
        );
    }

    /**
     * @param  \Berita\V1\KontenEvent  $event
     * @return \Exception|null
     */
    public function createBeritaKonten(KontenEvent $event)
    {
        try {
            if (!($event->getInput() instanceof InputFilter))
                throw new \InvalidArgumentException('Input filter not set');

            $bodyRequest = $event->getInput()->getValues();
            $bodyRequest['foto'] = $bodyRequest['foto']['tmp_name'];
            $bodyRequest = str_replace("data", "assets", $bodyRequest);

            $hydratedEntity = $this->kontenHydrator
                ->hydrate(
                    $bodyRequest,
                    new KontenEntity()
                );

            $hydratedEntity->setCreatedAt(new \DateTime('now'));
            $hydratedEntity->setUpdatedAt(new \DateTime('now'));
            $entity = $this->kontenMapper->save($hydratedEntity);
            if (!$entity instanceof KontenEntity)
                throw new \Exception('$entity is not an instance of KontenEntity');

            $event->setKonten($entity);
            $this->logger->log(
                \Psr\Log\LogLevel::INFO,
                "{function} : New berita konten data {uuid} created successfully",
                [
                    'function'  => __FUNCTION__,
                    'uuid'      => $entity->getUuid(),
                ]
            );
        } catch (RuntimeException $ex) {
            $event->stopPropagation(true);
            $this->logger->log(
                \Psr\Log\LogLevel::ERROR,
                "{function} : Something error !\nError message: {message}",
                [
                    'function'  => __FUNCTION__,
                    'message'   => $ex->getMessage(),
                ]
            );
            return $ex;
        }

        return null;
    }

    /**
     * @param  \Berita\V1\KontenEvent  $event
     * @return \Exception|null
     */
    public function updateBeritaKonten(KontenEvent $event)
    {
        try {
            if (!($event->getInput() instanceof InputFilter))
                throw new \InvalidArgumentException('Input filter not set');

            $bodyRequest = $event->getInput()->getValues();
            $currentEntity = $event->getKonten();
            $currentEntity->setUpdatedAt(new \DateTime('now'));
            $hydratedEntity = $this->kontenHydrator
                ->hydrate(
                    $bodyRequest,
                    $currentEntity
                );

            $entity = $this->kontenMapper->save($hydratedEntity);
            if (!$entity instanceof KontenEntity)
                throw new \Exception('$entity is not an instance of KontenEntity');

            $event->setKonten($entity);
            $this->logger->log(
                \Psr\Log\LogLevel::INFO,
                "{function} : Berita Konten data {uuid} updated successfully",
                [
                    'function'  => __FUNCTION__,
                    'uuid'      => $entity->getUuid(),
                ]
            );
        } catch (RuntimeException $ex) {
            $event->stopPropagation(true);
            $this->logger->log(
                \Psr\Log\LogLevel::ERROR,
                "{function} : Something error !\nError message: {message}",
                [
                    'function'  => __FUNCTION__,
                    'message'   => $ex->getMessage(),
                ]
            );
            return $ex;
        }

        return null;
    }

    /**
     * @param  \Berita\V1\KontenEvent  $event
     * @return \Exception|null
     */
    public function deleteBeritaKonten(KontenEvent $event)
    {
        try {
            $targetEntity = $event->getKonten();
            $this->kontenMapper->delete($targetEntity);

            $this->logger->log(
                \Psr\Log\LogLevel::INFO,
                "{function} : Berita Konten data {uuid} deleted successfully",
                [
                    'function'  => __FUNCTION__,
                    'uuid'      => $targetEntity->getUuid(),
                ]
            );
        } catch (RuntimeException $ex) {
            $event->stopPropagation(true);
            $this->logger->log(
                \Psr\Log\LogLevel::ERROR,
                "{function} : Something error !\nError message: {message}",
                [
                    'function'  => __FUNCTION__,
                    'message'   => $ex->getMessage(),
                ]
            );
            return $ex;
        }

        return null;
    }
}
