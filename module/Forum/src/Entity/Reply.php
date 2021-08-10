<?php

namespace Forum\Entity;

use Aqilix\ORM\Entity\EntityInterface;

/**
 * Reply
 */
class Reply implements EntityInterface
{
    /**
     * @var string
     */
    private $replyBody;

    /**
     * @var string
     */
    private $replyAuthor;

    /**
     * @var string
     */
    private $replyAttach;

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
     * @var \Forum\Entity\Thread
     */
    private $thread;


    /**
     * Set replyBody.
     *
     * @param string $replyBody
     *
     * @return Reply
     */
    public function setReplyBody($replyBody)
    {
        $this->replyBody = $replyBody;

        return $this;
    }

    /**
     * Get replyBody.
     *
     * @return string
     */
    public function getReplyBody()
    {
        return $this->replyBody;
    }

    /**
     * Set replyAuthor.
     *
     * @param string $replyAuthor
     *
     * @return Reply
     */
    public function setReplyAuthor($replyAuthor)
    {
        $this->replyAuthor = $replyAuthor;

        return $this;
    }

    /**
     * Get replyAuthor.
     *
     * @return string
     */
    public function getReplyAuthor()
    {
        return $this->replyAuthor;
    }

    /**
     * Set replyAttach.
     *
     * @param string $replyAttach
     *
     * @return Reply
     */
    public function setReplyAttach($replyAttach)
    {
        $this->replyAttach = $replyAttach;

        return $this;
    }

    /**
     * Get replyAttach.
     *
     * @return string
     */
    public function getReplyAttach()
    {
        return $this->replyAttach;
    }

    /**
     * Set createdAt.
     *
     * @param \DateTime $createdAt
     *
     * @return Reply
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
     * @return Reply
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
     * @return Reply
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
     * Set thread.
     *
     * @param \Forum\Entity\Thread|null $thread
     *
     * @return Thread
     */
    public function setThread(\Forum\Entity\Thread $thread = null)
    {
        $this->thread = $thread;

        return $this;
    }

    /**
     * Get thread.
     *
     * @return \Forum\Entity\Thread|null
     */
    public function getThread()
    {
        return $this->thread;
    }
}
