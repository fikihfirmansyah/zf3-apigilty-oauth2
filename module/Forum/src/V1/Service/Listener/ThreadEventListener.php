<?php

namespace Forum\V1\Service\Listener;

use Psr\Log\LoggerAwareTrait;
use Forum\Entity\Thread as ThreadEntity;
use Forum\Mapper\Thread as ThreadMapper;
use Forum\V1\ThreadEvent;
use Zend\EventManager\EventManagerAwareTrait;
use Zend\EventManager\EventManagerInterface;
use Zend\EventManager\ListenerAggregateInterface;
use Zend\EventManager\ListenerAggregateTrait;
use Zend\InputFilter\InputFilter;
use Zend\Log\Exception\RuntimeException;

class ThreadEventListener implements ListenerAggregateInterface
{
    use ListenerAggregateTrait;
    use EventManagerAwareTrait;
    use LoggerAwareTrait;

    protected $config;
    protected $threadMapper;
    protected $threadHydrator;
    protected $logger;

    /**
     * @param  mixed  $config
     * @param  \Forum\Mapper\Thread  $threadMapper
     * @param  mixed  $threadHydrator
     * @param  mixed  $logger
     */
    public function __construct(
        $config,
        ThreadMapper $threadMapper,
        $threadHydrator,
        $logger
    ) {
        $this->config = $config;
        $this->threadMapper = $threadMapper;
        $this->threadHydrator = $threadHydrator;
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
            ThreadEvent::EVENT_CREATE_THREAD,
            [$this, 'createForumThread'],
            500
        );
        $this->listeners[] = $events->attach(
            ThreadEvent::EVENT_UPDATE_THREAD,
            [$this, 'updateForumThread'],
            500
        );
        $this->listeners[] = $events->attach(
            ThreadEvent::EVENT_DELETE_THREAD,
            [$this, 'deleteForumThread'],
            500
        );
    }

    /**
     * @param  \Forum\V1\ThreadEvent  $event
     * @return \Exception|null
     */
    public function createForumThread(ThreadEvent $event)
    {
        try {
            if (!($event->getInput() instanceof InputFilter))
                throw new \InvalidArgumentException('Input filter not set');

            $bodyRequest = $event->getInput()->getValues();
            $bodyRequest['threadAttach'] = $bodyRequest['threadAttach']['tmp_name'];
            $bodyRequest = str_replace("data", "assets", $bodyRequest);
            $hydratedEntity = $this->threadHydrator
                ->hydrate(
                    $bodyRequest,
                    new ThreadEntity()
                );

            $hydratedEntity->setCreatedAt(new \DateTime('now'));
            $hydratedEntity->setUpdatedAt(new \DateTime('now'));
            $entity = $this->threadMapper->save($hydratedEntity);
            if (!$entity instanceof ThreadEntity)
                throw new \Exception('$entity is not an instance of ThreadEntity');

            $event->setThread($entity);
            $this->logger->log(
                \Psr\Log\LogLevel::INFO,
                "{function} : New forum thread data {uuid} created successfully",
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
     * @param  \Forum\V1\ThreadEvent  $event
     * @return \Exception|null
     */
    public function updateForumThread(ThreadEvent $event)
    {
        try {
            if (!($event->getInput() instanceof InputFilter))
                throw new \InvalidArgumentException('Input filter not set');

            $bodyRequest = $event->getInput()->getValues();
            $bodyRequest['threadAttach'] = $bodyRequest['threadAttach']['tmp_name'];
            $bodyRequest = str_replace("data", "assets", $bodyRequest);
            $currentEntity = $event->getThread();
            $currentEntity->setUpdatedAt(new \DateTime('now'));
            $hydratedEntity = $this->threadHydrator
                ->hydrate(
                    $bodyRequest,
                    $currentEntity
                );

            $entity = $this->threadMapper->save($hydratedEntity);
            if (!$entity instanceof ThreadEntity)
                throw new \Exception('$entity is not an instance of ThreadEntity');

            $event->setThread($entity);
            $this->logger->log(
                \Psr\Log\LogLevel::INFO,
                "{function} : Forum Thread data {uuid} updated successfully",
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
     * @param  \Forum\V1\ThreadEvent  $event
     * @return \Exception|null
     */
    public function deleteForumThread(ThreadEvent $event)
    {
        try {
            $targetEntity = $event->getThread();
            $this->threadMapper->delete($targetEntity);

            $this->logger->log(
                \Psr\Log\LogLevel::INFO,
                "{function} : Forum Thread data {uuid} deleted successfully",
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
