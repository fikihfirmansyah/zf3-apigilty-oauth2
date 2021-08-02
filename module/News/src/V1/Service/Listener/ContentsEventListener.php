<?php

namespace News\V1\Service\Listener;

use Psr\Log\LoggerAwareTrait;
use News\Entity\Contents as ContentsEntity;
use News\Mapper\Contents as ContentsMapper;
use News\V1\ContentsEvent;
use Zend\EventManager\EventManagerAwareTrait;
use Zend\EventManager\EventManagerInterface;
use Zend\EventManager\ListenerAggregateInterface;
use Zend\EventManager\ListenerAggregateTrait;
use Zend\InputFilter\InputFilter;
use Zend\Log\Exception\RuntimeException;

class ContentsEventListener implements ListenerAggregateInterface
{
    use ListenerAggregateTrait;
    use EventManagerAwareTrait;
    use LoggerAwareTrait;

    protected $config;
    protected $contentsMapper;
    protected $contentsHydrator;
    protected $logger;

    /**
     * @param  mixed  $config
     * @param  \News\Mapper\Contents  $contentsMapper
     * @param  mixed  $contentsHydrator
     * @param  mixed  $logger
     */
    public function __construct(
        $config,
        ContentsMapper $contentsMapper,
        $contentsHydrator,
        $logger
    ) {
        $this->config = $config;
        $this->contentsMapper = $contentsMapper;
        $this->contentsHydrator = $contentsHydrator;
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
            ContentsEvent::EVENT_CREATE_CONTENTS,
            [$this, 'createNewsContents'],
            500
        );
        $this->listeners[] = $events->attach(
            ContentsEvent::EVENT_UPDATE_CONTENTS,
            [$this, 'updateNewsContents'],
            500
        );
        $this->listeners[] = $events->attach(
            ContentsEvent::EVENT_DELETE_CONTENTS,
            [$this, 'deleteNewsContents'],
            500
        );
    }

    /**
     * @param  \News\V1\ContentsEvent  $event
     * @return \Exception|null
     */
    public function createNewsContents(ContentsEvent $event)
    {
        try {
            if (!($event->getInput() instanceof InputFilter))
                throw new \InvalidArgumentException('Input filter not set');

            $bodyRequest = $event->getInput()->getValues();
            $hydratedEntity = $this->contentsHydrator
                ->hydrate(
                    $bodyRequest,
                    new ContentsEntity()
                );

            $hydratedEntity->setCreatedAt(new \DateTime('now'));
            $hydratedEntity->setUpdatedAt(new \DateTime('now'));
            $entity = $this->contentsMapper->save($hydratedEntity);
            if (!$entity instanceof ContentsEntity)
                throw new \Exception('$entity is not an instance of ContentsEntity');

            $event->setContents($entity);
            $this->logger->log(
                \Psr\Log\LogLevel::INFO,
                "{function} : New news contents data {uuid} created successfully",
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
     * @param  \News\V1\ContentsEvent  $event
     * @return \Exception|null
     */
    public function updateNewsContents(ContentsEvent $event)
    {
        try {
            if (!($event->getInput() instanceof InputFilter))
                throw new \InvalidArgumentException('Input filter not set');

            $bodyRequest = $event->getInput()->getValues();
            $currentEntity = $event->getContents();
            $currentEntity->setUpdatedAt(new \DateTime('now'));
            $hydratedEntity = $this->contentsHydrator
                ->hydrate(
                    $bodyRequest,
                    $currentEntity
                );

            $entity = $this->contentsMapper->save($hydratedEntity);
            if (!$entity instanceof ContentsEntity)
                throw new \Exception('$entity is not an instance of ContentsEntity');

            $event->setContents($entity);
            $this->logger->log(
                \Psr\Log\LogLevel::INFO,
                "{function} : News Contents data {uuid} updated successfully",
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
     * @param  \News\V1\ContentsEvent  $event
     * @return \Exception|null
     */
    public function deleteNewsContents(ContentsEvent $event)
    {
        try {
            $targetEntity = $event->getContents();
            $this->contentsMapper->delete($targetEntity);

            $this->logger->log(
                \Psr\Log\LogLevel::INFO,
                "{function} : News Contents data {uuid} deleted successfully",
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
