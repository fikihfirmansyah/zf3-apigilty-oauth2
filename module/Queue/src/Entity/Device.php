<?php

namespace Queue\Entity;

use Aqilix\ORM\Entity\EntityInterface;

/**
 * Device
 */
class Device implements EntityInterface
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $description;

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
     * @var \Doctrine\Common\Collections\Collection
     */
    private $logs;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $logDailySummaries;

    /**
     * @var \Queue\Entity\Site
     */
    private $site;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->logs = new \Doctrine\Common\Collections\ArrayCollection();
        $this->logDailySummaries = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set name.
     *
     * @param string $name
     *
     * @return Device
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set description.
     *
     * @param string $description
     *
     * @return Device
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description.
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set createdAt.
     *
     * @param \DateTime $createdAt
     *
     * @return Device
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
     * @return Device
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
     * @return Device
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
     * Add log.
     *
     * @param \Queue\Entity\Log $log
     *
     * @return Device
     */
    public function addLog(\Queue\Entity\Log $log)
    {
        $this->logs[] = $log;

        return $this;
    }

    /**
     * Remove log.
     *
     * @param \Queue\Entity\Log $log
     *
     * @return boolean TRUE if this collection contained the specified element, FALSE otherwise.
     */
    public function removeLog(\Queue\Entity\Log $log)
    {
        return $this->logs->removeElement($log);
    }

    /**
     * Get logs.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getLogs()
    {
        return $this->logs;
    }

    /**
     * Add logDailySummary.
     *
     * @param \Queue\Entity\LogDailySummary $logDailySummary
     *
     * @return Device
     */
    public function addLogDailySummary(\Queue\Entity\LogDailySummary $logDailySummary)
    {
        $this->logDailySummaries[] = $logDailySummary;

        return $this;
    }

    /**
     * Remove logDailySummary.
     *
     * @param \Queue\Entity\LogDailySummary $logDailySummary
     *
     * @return boolean TRUE if this collection contained the specified element, FALSE otherwise.
     */
    public function removeLogDailySummary(\Queue\Entity\LogDailySummary $logDailySummary)
    {
        return $this->logDailySummaries->removeElement($logDailySummary);
    }

    /**
     * Get logDailySummaries.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getLogDailySummaries()
    {
        return $this->logDailySummaries;
    }

    /**
     * Set site.
     *
     * @param \Queue\Entity\Site|null $site
     *
     * @return Device
     */
    public function setSite(\Queue\Entity\Site $site = null)
    {
        $this->site = $site;

        return $this;
    }

    /**
     * Get site.
     *
     * @return \Queue\Entity\Site|null
     */
    public function getSite()
    {
        return $this->site;
    }
}
