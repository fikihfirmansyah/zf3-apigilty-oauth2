<?php

namespace Forum\Entity;

use Aqilix\ORM\Entity\EntityInterface;

/**
 * Thread
 */
class Thread implements EntityInterface
{
    /**
     * @var string
     */
    private $threadTitle;

    /**
     * @var string
     */
    private $threadBody;

    /**
     * @var string
     */
    private $threadTags;

    /**
     * @var string
     */
    private $threadAuthor;

    /**
     * @var string
     */
    private $threadAttach;

    /**
     * @var string
     */
    private $threadCategory;

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
     * Set threadTitle.
     *
     * @param string $threadTitle
     *
     * @return Thread
     */
    public function setThreadTitle($threadTitle)
    {
        $this->threadTitle = $threadTitle;

        return $this;
    }

    /**
     * Get threadTitle.
     *
     * @return string
     */
    public function getThreadTitle()
    {
        return $this->threadTitle;
    }

    /**
     * Set threadBody.
     *
     * @param string $threadBody
     *
     * @return Thread
     */
    public function setThreadBody($threadBody)
    {
        $this->threadBody = $threadBody;

        return $this;
    }

    /**
     * Get threadBody.
     *
     * @return string
     */
    public function getThreadBody()
    {
        return $this->threadBody;
    }

    /**
     * Set threadTags.
     *
     * @param string $threadTags
     *
     * @return Thread
     */
    public function setThreadTags($threadTags)
    {
        $this->threadTags = $threadTags;

        return $this;
    }

    /**
     * Get threadTags.
     *
     * @return string
     */
    public function getThreadTags()
    {
        return $this->threadTags;
    }

    /**
     * Set threadAuthor.
     *
     * @param string $threadAuthor
     *
     * @return Thread
     */
    public function setThreadAuthor($threadAuthor)
    {
        $this->threadAuthor = $threadAuthor;

        return $this;
    }

    /**
     * Get threadAuthor.
     *
     * @return string
     */
    public function getThreadAuthor()
    {
        return $this->threadAuthor;
    }

    /**
     * Set threadAttach.
     *
     * @param string $threadAttach
     *
     * @return Thread
     */
    public function setThreadAttach($threadAttach)
    {
        $this->threadAttach = $threadAttach;

        return $this;
    }

    /**
     * Get threadAttach.
     *
     * @return string
     */
    public function getThreadAttach()
    {
        return $this->threadAttach;
    }

    /**
     * Set threadCategory.
     *
     * @param string $threadCategory
     *
     * @return Thread
     */
    public function setThreadCategory($threadCategory)
    {
        $this->threadCategory = $threadCategory;

        return $this;
    }

    /**
     * Get threadCategory.
     *
     * @return string
     */
    public function getThreadCategory()
    {
        return $this->threadCategory;
    }

    /**
     * Set createdAt.
     *
     * @param \DateTime $createdAt
     *
     * @return Thread
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
     * @return Thread
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
     * @return Thread
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
}
