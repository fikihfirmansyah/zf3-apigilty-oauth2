<?php

namespace Queue\V1\Service\Listener;

use Psr\Log\LoggerAwareTrait;
use Queue\Entity\Site as SiteEntity;
use Queue\Mapper\Site as SiteMapper;
use Queue\V1\SiteEvent;
use Zend\EventManager\EventManagerAwareTrait;
use Zend\EventManager\EventManagerInterface;
use Zend\EventManager\ListenerAggregateInterface;
use Zend\EventManager\ListenerAggregateTrait;
use Zend\InputFilter\InputFilter;
use Zend\Log\Exception\RuntimeException;

class SiteEventListener implements ListenerAggregateInterface
{
    use ListenerAggregateTrait;
    use EventManagerAwareTrait;
    use LoggerAwareTrait;

    protected $config;
    protected $queueSiteMapper;
    protected $queueSiteHydrator;
    protected $logger;

    /**
     * @param  mixed  $config
     * @param  \Queue\Mapper\Site  $queueSiteMapper
     * @param  mixed  $queueSiteHydrator
     * @param  mixed  $logger
     */
    public function __construct(
        $config,
        SiteMapper $queueSiteMapper,
        $queueSiteHydrator,
        $logger
    ) {
        $this->config = $config;
        $this->queueSiteMapper = $queueSiteMapper;
        $this->queueSiteHydrator = $queueSiteHydrator;
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
            SiteEvent::EVENT_CREATE_QUEUE_SITE,
            [$this, 'createQueueSite'],
            500
        );
        $this->listeners[] = $events->attach(
            SiteEvent::EVENT_UPDATE_QUEUE_SITE,
            [$this, 'updateQueueSite'],
            500
        );
        $this->listeners[] = $events->attach(
            SiteEvent::EVENT_DELETE_QUEUE_SITE,
            [$this, 'deleteQueueSite'],
            500
        );
    }

    /**
     * @param  \Queue\V1\SiteEvent  $event
     * @return \Exception|null
     */
    public function createQueueSite(SiteEvent $event)
    {
        try {
            if(!($event->getInput() instanceof InputFilter))
                throw new \InvalidArgumentException('Input filter not set');

            $bodyRequest = $event->getInput()->getValues();
            $hydratedEntity = $this->queueSiteHydrator
                ->hydrate(
                    $bodyRequest,
                    new SiteEntity()
                );

            $hydratedEntity->setCreatedAt(new \DateTime('now'));
            $hydratedEntity->setUpdatedAt(new \DateTime('now'));
            $entity = $this->queueSiteMapper->save($hydratedEntity);
            if(!$entity instanceof SiteEntity)
                throw new \Exception('$entity is not an instance of SiteEntity');

            $event->setSite($entity);
            $this->logger->log(
                \Psr\Log\LogLevel::INFO,
                "{function} : New queue site data {uuid} created successfully",
                [
                    'function'  => __FUNCTION__,
                    'uuid'      => $entity->getUuid(),
                ]
            );
        } catch(RuntimeException $ex) {
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
     * @param  \Queue\V1\SiteEvent  $event
     * @return \Exception|null
     */
    public function updateQueueSite(SiteEvent $event)
    {
        try {
            if(!($event->getInput() instanceof InputFilter))
                throw new \InvalidArgumentException('Input filter not set');

            $bodyRequest = $event->getInput()->getValues();
            $currentEntity = $event->getSite();
            $currentEntity->setUpdatedAt(new \DateTime('now'));
            $hydratedEntity = $this->queueSiteHydrator
                ->hydrate(
                    $bodyRequest,
                    $currentEntity
                );

            $entity = $this->queueSiteMapper->save($hydratedEntity);
            if(!$entity instanceof SiteEntity)
                throw new \Exception('$entity is not an instance of SiteEntity');

            $event->setSite($entity);
            $this->logger->log(
                \Psr\Log\LogLevel::INFO,
                "{function} : Queue Site data {uuid} updated successfully",
                [
                    'function'  => __FUNCTION__,
                    'uuid'      => $entity->getUuid(),
                ]
            );
        } catch(RuntimeException $ex) {
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
     * @param  \Queue\V1\SiteEvent  $event
     * @return \Exception|null
     */
    public function deleteQueueSite(SiteEvent $event)
    {
        try {
            $targetEntity = $event->getSite();
            $this->queueSiteMapper->delete($targetEntity);

            $this->logger->log(
                \Psr\Log\LogLevel::INFO,
                "{function} : Queue Site data {uuid} deleted successfully",
                [
                    'function'  => __FUNCTION__,
                    'uuid'      => $targetEntity->getUuid(),
                ]
            );
        } catch(RuntimeException $ex) {
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
