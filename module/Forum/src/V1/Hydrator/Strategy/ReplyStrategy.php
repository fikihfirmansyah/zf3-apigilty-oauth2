<?php

namespace Forum\V1\Hydrator\Strategy;

use DoctrineModule\Stdlib\Hydrator\Strategy\AbstractCollectionStrategy;
use Zend\Hydrator\Strategy\StrategyInterface;
use Forum\Entity\Reply;

/**
 * Class ReplyStrategy
 *
 * @package User\Stdlib\Hydrator\Strategy
 */
class ReplyStrategy extends AbstractCollectionStrategy implements StrategyInterface
{
    /**
     * Converts the given value so that it can be extracted by the hydrator.
     *
     * @param  mixed $value The original value.
     * @param  object $object (optional) The original object for context.
     * @return mixed Returns the value that should be extracted.
     * @throws \RuntimeException If object os not a User
     *
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function extract($value, $object = null)
    {
        if (!is_null($value) && $value instanceof Reply)
            return [
                'uuid'      => $value->getUuid(),
                'reply_body'      => $value->getReplyBody(),
            ];

        return null;
    }

    /**
     * Converts the given value so that it can be hydrated by the hydrator.
     *
     * @param  mixed $value The original value.
     * @param  array $data (optional) The original data for context.
     * @return mixed Returns the value that should be hydrated.
     * @throws \InvalidArgumentException
     *
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function hydrate($value, array $data = null)
    {
        return $value;
    }
}
