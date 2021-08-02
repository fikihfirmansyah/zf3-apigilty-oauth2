<?php

namespace News\V1\Service\Listener;

use Psr\Log\LoggerAwareTrait;
use News\Entity\Comments as CommentsEntity;
use News\Mapper\Comments as CommentsMapper;
use News\V1\CommentsEvent;
use Zend\EventManager\EventManagerAwareTrait;
use Zend\EventManager\EventManagerInterface;
use Zend\EventManager\ListenerAggregateInterface;
use Zend\EventManager\ListenerAggregateTrait;
use Zend\InputFilter\InputFilter;
use Zend\Log\Exception\RuntimeException;

class CommentsEventListener implements ListenerAggregateInterface
{
    use ListenerAggregateTrait;
    use EventManagerAwareTrait;
    use LoggerAwareTrait;

    protected $config;
    protected $commentsMapper;
    protected $commentsHydrator;
    protected $logger;

    /**
     * @param  mixed  $config
     * @param  \News\Mapper\Comments  $commentsMapper
     * @param  mixed  $commentsHydrator
     * @param  mixed  $logger
     */
    public function __construct(
        $config,
        CommentsMapper $commentsMapper,
        $commentsHydrator,
        $logger
    ) {
        $this->config = $config;
        $this->commentsMapper = $commentsMapper;
        $this->commentsHydrator = $commentsHydrator;
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
            CommentsEvent::EVENT_CREATE_COMMENTS,
            [$this, 'createNewsComments'],
            500
        );
        $this->listeners[] = $events->attach(
            CommentsEvent::EVENT_UPDATE_COMMENTS,
            [$this, 'updateNewsComments'],
            500
        );
        $this->listeners[] = $events->attach(
            CommentsEvent::EVENT_DELETE_COMMENTS,
            [$this, 'deleteNewsComments'],
            500
        );
    }

    /**
     * @param  \News\V1\CommentsEvent  $event
     * @return \Exception|null
     */
    public function createNewsComments(CommentsEvent $event)
    {
        try {
            if (!($event->getInput() instanceof InputFilter))
                throw new \InvalidArgumentException('Input filter not set');

            $bodyRequest = $event->getInput()->getValues();
            $hydratedEntity = $this->commentsHydrator
                ->hydrate(
                    $bodyRequest,
                    new CommentsEntity()
                );

            $hydratedEntity->setCreatedAt(new \DateTime('now'));
            $hydratedEntity->setUpdatedAt(new \DateTime('now'));
            $entity = $this->commentsMapper->save($hydratedEntity);
            if (!$entity instanceof CommentsEntity)
                throw new \Exception('$entity is not an instance of CommentsEntity');

            $event->setComments($entity);
            $this->logger->log(
                \Psr\Log\LogLevel::INFO,
                "{function} : New comments data {uuid} created successfully",
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
     * @param  \News\V1\CommentsEvent  $event
     * @return \Exception|null
     */
    public function updateNewsComments(CommentsEvent $event)
    {
        try {
            if (!($event->getInput() instanceof InputFilter))
                throw new \InvalidArgumentException('Input filter not set');

            $bodyRequest = $event->getInput()->getValues();
            $currentEntity = $event->getComments();
            $currentEntity->setUpdatedAt(new \DateTime('now'));
            $hydratedEntity = $this->commentsHydrator
                ->hydrate(
                    $bodyRequest,
                    $currentEntity
                );

            $entity = $this->commentsMapper->save($hydratedEntity);
            if (!$entity instanceof CommentsEntity)
                throw new \Exception('$entity is not an instance of CommentsEntity');

            $event->setComments($entity);
            $this->logger->log(
                \Psr\Log\LogLevel::INFO,
                "{function} : News Comments data {uuid} updated successfully",
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
     * @param  \News\V1\CommentsEvent  $event
     * @return \Exception|null
     */
    public function deleteNewsComments(CommentsEvent $event)
    {
        try {
            $targetEntity = $event->getComments();
            $this->commentsMapper->delete($targetEntity);

            $this->logger->log(
                \Psr\Log\LogLevel::INFO,
                "{function} : News Comments data {uuid} deleted successfully",
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
