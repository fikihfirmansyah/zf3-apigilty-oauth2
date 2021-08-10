<?php

namespace Forum\V1\Service\Listener;

use Psr\Log\LoggerAwareTrait;
use Forum\Entity\Reply as ReplyEntity;
use Forum\Mapper\Reply as ReplyMapper;
use Forum\V1\ReplyEvent;
use Zend\EventManager\EventManagerAwareTrait;
use Zend\EventManager\EventManagerInterface;
use Zend\EventManager\ListenerAggregateInterface;
use Zend\EventManager\ListenerAggregateTrait;
use Zend\InputFilter\InputFilter;
use Zend\Log\Exception\RuntimeException;

class ReplyEventListener implements ListenerAggregateInterface
{
    use ListenerAggregateTrait;
    use EventManagerAwareTrait;
    use LoggerAwareTrait;

    protected $config;
    protected $replyMapper;
    protected $replyHydrator;
    protected $logger;

    /**
     * @param  mixed  $config
     * @param  \Forum\Mapper\Reply  $replyMapper
     * @param  mixed  $replyHydrator
     * @param  mixed  $logger
     */
    public function __construct(
        $config,
        ReplyMapper $replyMapper,
        $replyHydrator,
        $logger
    ) {
        $this->config = $config;
        $this->replyMapper = $replyMapper;
        $this->replyHydrator = $replyHydrator;
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
            ReplyEvent::EVENT_CREATE_REPLY,
            [$this, 'createForumReply'],
            500
        );
        $this->listeners[] = $events->attach(
            ReplyEvent::EVENT_UPDATE_REPLY,
            [$this, 'updateForumReply'],
            500
        );
        $this->listeners[] = $events->attach(
            ReplyEvent::EVENT_DELETE_REPLY,
            [$this, 'deleteForumReply'],
            500
        );
    }

    /**
     * @param  \Forum\V1\ReplyEvent  $event
     * @return \Exception|null
     */
    public function createForumReply(ReplyEvent $event)
    {
        try {
            if (!($event->getInput() instanceof InputFilter))
                throw new \InvalidArgumentException('Input filter not set');

            $bodyRequest = $event->getInput()->getValues();
            $bodyRequest['replyAttach'] = $bodyRequest['replyAttach']['tmp_name'];
            $bodyRequest = str_replace("data", "assets", $bodyRequest);
            $hydratedEntity = $this->replyHydrator
                ->hydrate(
                    $bodyRequest,
                    new ReplyEntity()
                );

            $hydratedEntity->setCreatedAt(new \DateTime('now'));
            $hydratedEntity->setUpdatedAt(new \DateTime('now'));
            $entity = $this->replyMapper->save($hydratedEntity);
            if (!$entity instanceof ReplyEntity)
                throw new \Exception('$entity is not an instance of ReplyEntity');

            $event->setReply($entity);
            $this->logger->log(
                \Psr\Log\LogLevel::INFO,
                "{function} : New reply data {uuid} created successfully",
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
     * @param  \Forum\V1\ReplyEvent  $event
     * @return \Exception|null
     */
    public function updateForumReply(ReplyEvent $event)
    {
        try {
            if (!($event->getInput() instanceof InputFilter))
                throw new \InvalidArgumentException('Input filter not set');

            $bodyRequest = $event->getInput()->getValues();
            $bodyRequest['replyAttach'] = $bodyRequest['replyAttach']['tmp_name'];
            $bodyRequest = str_replace("data", "assets", $bodyRequest);

            $currentEntity = $event->getReply();
            $currentEntity->setUpdatedAt(new \DateTime('now'));
            $hydratedEntity = $this->replyHydrator
                ->hydrate(
                    $bodyRequest,
                    $currentEntity
                );

            $entity = $this->replyMapper->save($hydratedEntity);
            if (!$entity instanceof ReplyEntity)
                throw new \Exception('$entity is not an instance of ReplyEntity');

            $event->setReply($entity);
            $this->logger->log(
                \Psr\Log\LogLevel::INFO,
                "{function} : Forum Reply data {uuid} updated successfully",
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
     * @param  \Forum\V1\ReplyEvent  $event
     * @return \Exception|null
     */
    public function deleteForumReply(ReplyEvent $event)
    {
        try {
            $targetEntity = $event->getReply();
            $this->replyMapper->delete($targetEntity);

            $this->logger->log(
                \Psr\Log\LogLevel::INFO,
                "{function} : Forum Reply data {uuid} deleted successfully",
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
