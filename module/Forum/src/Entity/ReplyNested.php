<?php

namespace Forum\Entity;

use Aqilix\ORM\Entity\EntityInterface;

/**
 * ReplyNested
 */
class ReplyNested implements EntityInterface
{
    /**
     * @var string
     */
    private $replyNestedBody;

    /**
     * @var string
     */
    private $replyNestedAuthor;

    /**
     * @var string
     */
    private $replyNestedAttach;

    /**
     * @var \DateTime
     */
    private $createdAt = 'CURRENT_TIMESTAMP';

    /**
     * @var \DateTime
     */
    private $updatedAt = 'CURRENT_TIMESTAMP';

    /**
     * @var \DateTime|null
     */
    private $deletedAt;

    /**
     * @var string
     */
    private $uuid;

    /**
     * @var \Forum\Entity\Reply
     */
    private $reply;


    /**
     * Set replyNestedBody.
     *
     * @param string $replyNestedBody
     *
     * @return ReplyNested
     */
    public function setReplyNestedBody($replyNestedBody)
    {
        $this->replyNestedBody = $replyNestedBody;

        return $this;
    }

    /**
     * Get replyNestedBody.
     *
     * @return string
     */
    public function getReplyNestedBody()
    {
        return $this->replyNestedBody;
    }

    /**
     * Set replyNestedAuthor.
     *
     * @param string $replyNestedAuthor
     *
     * @return ReplyNested
     */
    public function setReplyNestedAuthor($replyNestedAuthor)
    {
        $this->replyNestedAuthor = $replyNestedAuthor;

        return $this;
    }

    /**
     * Get replyNestedAuthor.
     *
     * @return string
     */
    public function getReplyNestedAuthor()
    {
        return $this->replyNestedAuthor;
    }

    /**
     * Set replyNestedAttach.
     *
     * @param string $replyNestedAttach
     *
     * @return ReplyNested
     */
    public function setReplyNestedAttach($replyNestedAttach)
    {
        $this->replyNestedAttach = $replyNestedAttach;

        return $this;
    }

    /**
     * Get replyNestedAttach.
     *
     * @return string
     */
    public function getReplyNestedAttach()
    {
        return $this->replyNestedAttach;
    }

    /**
     * Set createdAt.
     *
     * @param \DateTime $createdAt
     *
     * @return ReplyNested
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt.
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set updatedAt.
     *
     * @param \DateTime $updatedAt
     *
     * @return ReplyNested
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Get updatedAt.
     *
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * Set deletedAt.
     *
     * @param \DateTime|null $deletedAt
     *
     * @return ReplyNested
     */
    public function setDeletedAt($deletedAt = null)
    {
        $this->deletedAt = $deletedAt;

        return $this;
    }

    /**
     * Get deletedAt.
     *
     * @return \DateTime|null
     */
    public function getDeletedAt()
    {
        return $this->deletedAt;
    }

    /**
     * Get uuid.
     *
     * @return string
     */
    public function getUuid()
    {
        return $this->uuid;
    }

    /**
     * Set reply.
     *
     * @param \Forum\Entity\Reply|null $reply
     *
     * @return Reply
     */
    public function setReply(\Forum\Entity\Reply $reply = null)
    {
        $this->reply = $reply;

        return $this;
    }

    /**
     * Get reply.
     *
     * @return \Forum\Entity\Reply|null
     */
    public function getReply()
    {
        return $this->reply;
    }
}
