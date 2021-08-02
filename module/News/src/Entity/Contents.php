<?php

namespace News\Entity;

use Aqilix\ORM\Entity\EntityInterface;

/**
 * Contents
 */
class Contents implements EntityInterface
{
    /**
     * @var string
     */
    private $titles;

    /**
     * @var string
     */
    private $articles;

    /**
     * @var string
     */
    private $authors;

    /**
     * @var string
     */
    private $categorys;

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
     * Set titles.
     *
     * @param string $titles
     *
     * @return Contents
     */
    public function setTitles($titles)
    {
        $this->titles = $titles;

        return $this;
    }

    /**
     * Get titles.
     *
     * @return string
     */
    public function getTitles()
    {
        return $this->titles;
    }

    /**
     * Set articles.
     *
     * @param string $articles
     *
     * @return Contents
     */
    public function setArticles($articles)
    {
        $this->articles = $articles;

        return $this;
    }

    /**
     * Get articles.
     *
     * @return string
     */
    public function getArticles()
    {
        return $this->articles;
    }

    /**
     * Set authors.
     *
     * @param string $authors
     *
     * @return Contents
     */
    public function setAuthors($authors)
    {
        $this->authors = $authors;

        return $this;
    }

    /**
     * Get authors.
     *
     * @return string
     */
    public function getAuthors()
    {
        return $this->authors;
    }

    /**
     * Set categorys.
     *
     * @param string $categorys
     *
     * @return Contents
     */
    public function setCategorys($categorys)
    {
        $this->categorys = $categorys;

        return $this;
    }

    /**
     * Get categorys.
     *
     * @return string
     */
    public function getCategorys()
    {
        return $this->categorys;
    }

    /**
     * Set createdAt.
     *
     * @param \DateTime $createdAt
     *
     * @return Contents
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
     * @return Contents
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
     * @return Contents
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
