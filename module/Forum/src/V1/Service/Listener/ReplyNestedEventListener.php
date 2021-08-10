<?php

namespace Forum\V1\Service\Listener;

use Psr\Log\LoggerAwareTrait;
use Forum\Entity\ReplyNested as ReplyNestedEntity;
use Forum\Mapper\ReplyNested as ReplyNestedMapper;
use Forum\V1\ReplyNestedEvent;
use Zend\EventManager\EventManagerAwareTrait;
use Zend\EventManager\EventManagerInterface;
use Zend\EventManager\ListenerAggregateInterface;
use Zend\EventManager\ListenerAggregateTrait;
use Zend\InputFilter\InputFilter;
use Zend\Log\Exception\RuntimeException;

class ReplyNestedEventListener implements ListenerAggregateInterface
{
    use ListenerAggregateTrait;
    use EventManagerAwareTrait;
    use LoggerAwareTrait;

    protected $config;
    protected $replyNestedMapper;
    protected $replyNestedHydrator;
    protected $logger;

    /**
     * @param  mixed  $config
     * @param  \Forum\Mapper\ReplyNested  $replyNestedMapper
     * @param  mixed  $replyNestedHydrator
     * @param  mixed  $logger
     */
    public function __construct(
        $config,
        ReplyNestedMapper $replyNestedMapper,
        $replyNestedHydrator,
        $logger
    ) {
        $this->config = $config;
        $this->replyNestedMapper = $replyNestedMapper;
        $this->replyNestedHydrator = $replyNestedHydrator;
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
            ReplyNestedEvent::EVENT_CREATE_REPLY_NESTED,
            [$this, 'createForumReplyNested'],
            500
        );
        $this->listeners[] = $events->attach(
            ReplyNestedEvent::EVENT_UPDATE_REPLY_NESTED,
            [$this, 'updateForumReplyNested'],
            500
        );
        $this->listeners[] = $events->attach(
            ReplyNestedEvent::EVENT_DELETE_REPLY_NESTED,
            [$this, 'deleteForumReplyNested'],
            500
        );
    }

    /**
     * @param  \Forum\V1\ReplyNestedEvent  $event
     * @return \Exception|null
     */
    public function createForumReplyNested(ReplyNestedEvent $event)
    {
        try {
            if (!($event->getInput() instanceof InputFilter))
                throw new \InvalidArgumentException('Input filter not set');

            $bodyRequest = $event->getInput()->getValues();
            $bodyRequest['replyNestedAttach'] = $bodyRequest['replyNestedAttach']['tmp_name'];
            $bodyRequest = str_replace("data", "assets", $bodyRequest);
            $hydratedEntity = $this->replyNestedHydrator
                ->hydrate(
                    $bodyRequest,
                    new ReplyNestedEntity()
                );

            $hydratedEntity->setCreatedAt(new \DateTime('now'));
            $hydratedEntity->setUpdatedAt(new \DateTime('now'));
            $entity = $this->replyNestedMapper->save($hydratedEntity);
            if (!$entity instanceof ReplyNestedEntity)
                throw new \Exception('$entity is not an instance of ReplyNestedEntity');

            $event->setReplyNested($entity);
            $this->logger->log(
                \Psr\Log\LogLevel::INFO,
                "{function} : New replyNested data {uuid} created successfully",
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
     * @param  \Forum\V1\ReplyNestedEvent  $event
     * @return \Exception|null
     */
    public function updateForumReplyNested(ReplyNestedEvent $event)
    {
        try {
            if (!($event->getInput() instanceof InputFilter))
                throw new \InvalidArgumentException('Input filter not set');

            $bodyRequest = $event->getInput()->getValues();
            $bodyRequest['replyNestedAttach'] = $bodyRequest['replyNestedAttach']['tmp_name'];
            $bodyRequest = str_replace("data", "assets", $bodyRequest);
            $currentEntity = $event->getReplyNested();
            $currentEntity->setUpdatedAt(new \DateTime('now'));
            $hydratedEntity = $this->replyNestedHydrator
                ->hydrate(
                    $bodyRequest,
                    $currentEntity
                );

            $entity = $this->replyNestedMapper->save($hydratedEntity);
            if (!$entity instanceof ReplyNestedEntity)
                throw new \Exception('$entity is not an instance of ReplyNestedEntity');

            $event->setReplyNested($entity);
            $this->logger->log(
                \Psr\Log\LogLevel::INFO,
                "{function} : Forum ReplyNested data {uuid} updated successfully",
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
     * @param  \Forum\V1\ReplyNestedEvent  $event
     * @return \Exception|null
     */
    public function deleteForumReplyNested(ReplyNestedEvent $event)
    {
        try {
            $targetEntity = $event->getReplyNested();
            $this->replyNestedMapper->delete($targetEntity);

            $this->logger->log(
                \Psr\Log\LogLevel::INFO,
                "{function} : Forum ReplyNested data {uuid} deleted successfully",
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
