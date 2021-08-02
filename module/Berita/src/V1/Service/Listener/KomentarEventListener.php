<?php

namespace Berita\V1\Service\Listener;

use Psr\Log\LoggerAwareTrait;
use Berita\Entity\Komentar as KomentarEntity;
use Berita\Mapper\Komentar as KomentarMapper;
use Berita\V1\KomentarEvent;
use Zend\EventManager\EventManagerAwareTrait;
use Zend\EventManager\EventManagerInterface;
use Zend\EventManager\ListenerAggregateInterface;
use Zend\EventManager\ListenerAggregateTrait;
use Zend\InputFilter\InputFilter;
use Zend\Log\Exception\RuntimeException;

class KomentarEventListener implements ListenerAggregateInterface
{
    use ListenerAggregateTrait;
    use EventManagerAwareTrait;
    use LoggerAwareTrait;

    protected $config;
    protected $komentarMapper;
    protected $komentarHydrator;
    protected $logger;

    /**
     * @param  mixed  $config
     * @param  \Berita\Mapper\Komentar  $komentarMapper
     * @param  mixed  $komentarHydrator
     * @param  mixed  $logger
     */
    public function __construct(
        $config,
        KomentarMapper $komentarMapper,
        $komentarHydrator,
        $logger
    ) {
        $this->config = $config;
        $this->komentarMapper = $komentarMapper;
        $this->komentarHydrator = $komentarHydrator;
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
            KomentarEvent::EVENT_CREATE_KOMENTAR,
            [$this, 'createBeritaKomentar'],
            500
        );
        $this->listeners[] = $events->attach(
            KomentarEvent::EVENT_UPDATE_KOMENTAR,
            [$this, 'updateBeritaKomentar'],
            500
        );
        $this->listeners[] = $events->attach(
            KomentarEvent::EVENT_DELETE_KOMENTAR,
            [$this, 'deleteBeritaKomentar'],
            500
        );
    }

    /**
     * @param  \Berita\V1\KomentarEvent  $event
     * @return \Exception|null
     */
    public function createBeritaKomentar(KomentarEvent $event)
    {
        try {
            if (!($event->getInput() instanceof InputFilter))
                throw new \InvalidArgumentException('Input filter not set');

            $bodyRequest = $event->getInput()->getValues();
            $hydratedEntity = $this->komentarHydrator
                ->hydrate(
                    $bodyRequest,
                    new KomentarEntity()
                );

            $hydratedEntity->setCreatedAt(new \DateTime('now'));
            $hydratedEntity->setUpdatedAt(new \DateTime('now'));
            $entity = $this->komentarMapper->save($hydratedEntity);
            if (!$entity instanceof KomentarEntity)
                throw new \Exception('$entity is not an instance of KomentarEntity');

            $event->setKomentar($entity);
            $this->logger->log(
                \Psr\Log\LogLevel::INFO,
                "{function} : New komentar data {uuid} created successfully",
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
     * @param  \Berita\V1\KomentarEvent  $event
     * @return \Exception|null
     */
    public function updateBeritaKomentar(KomentarEvent $event)
    {
        try {
            if (!($event->getInput() instanceof InputFilter))
                throw new \InvalidArgumentException('Input filter not set');

            $bodyRequest = $event->getInput()->getValues();
            $currentEntity = $event->getKomentar();
            $currentEntity->setUpdatedAt(new \DateTime('now'));
            $hydratedEntity = $this->komentarHydrator
                ->hydrate(
                    $bodyRequest,
                    $currentEntity
                );

            $entity = $this->komentarMapper->save($hydratedEntity);
            if (!$entity instanceof KomentarEntity)
                throw new \Exception('$entity is not an instance of KomentarEntity');

            $event->setKomentar($entity);
            $this->logger->log(
                \Psr\Log\LogLevel::INFO,
                "{function} : Berita Komentar data {uuid} updated successfully",
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
     * @param  \Berita\V1\KomentarEvent  $event
     * @return \Exception|null
     */
    public function deleteBeritaKomentar(KomentarEvent $event)
    {
        try {
            $targetEntity = $event->getKomentar();
            $this->komentarMapper->delete($targetEntity);

            $this->logger->log(
                \Psr\Log\LogLevel::INFO,
                "{function} : Berita Komentar data {uuid} deleted successfully",
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
