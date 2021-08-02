<?php

namespace Queue\Entity;

use Aqilix\ORM\Entity\EntityInterface;

/**
 * LogDailySummary
 */
class LogDailySummary implements EntityInterface
{
    /**
     * @var string
     */
    private $counterNumber;

    /**
     * @var \DateTime
     */
    private $date;

    /**
     * @var int
     */
    private $totalQueue = '0';

    /**
     * @var float
     */
    private $avgProcessingTime = '0';

    /**
     * @var float
     */
    private $avgWaitingTime = '0';

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
     * @var \Queue\Entity\Device
     */
    private $device;


    /**
     * Set counterNumber.
     *
     * @param string $counterNumber
     *
     * @return LogDailySummary
     */
    public function setCounterNumber($counterNumber)
    {
        $this->counterNumber = $counterNumber;

        return $this;
    }

    /**
     * Get counterNumber.
     *
     * @return string
     */
    public function getCounterNumber()
    {
        return $this->counterNumber;
    }

    /**
     * Set date.
     *
     * @param \DateTime $date
     *
     * @return LogDailySummary
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date.
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set totalQueue.
     *
     * @param int $totalQueue
     *
     * @return LogDailySummary
     */
    public function setTotalQueue($totalQueue)
    {
        $this->totalQueue = $totalQueue;

        return $this;
    }

    /**
     * Get totalQueue.
     *
     * @return int
     */
    public function getTotalQueue()
    {
        return $this->totalQueue;
    }

    /**
     * Set avgProcessingTime.
     *
     * @param float $avgProcessingTime
     *
     * @return LogDailySummary
     */
    public function setAvgProcessingTime($avgProcessingTime)
    {
        $this->avgProcessingTime = $avgProcessingTime;

        return $this;
    }

    /**
     * Get avgProcessingTime.
     *
     * @return float
     */
    public function getAvgProcessingTime()
    {
        return $this->avgProcessingTime;
    }

    /**
     * Set avgWaitingTime.
     *
     * @param float $avgWaitingTime
     *
     * @return LogDailySummary
     */
    public function setAvgWaitingTime($avgWaitingTime)
    {
        $this->avgWaitingTime = $avgWaitingTime;

        return $this;
    }

    /**
     * Get avgWaitingTime.
     *
     * @return float
     */
    public function getAvgWaitingTime()
    {
        return $this->avgWaitingTime;
    }

    /**
     * Set createdAt.
     *
     * @param \DateTime $createdAt
     *
     * @return LogDailySummary
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
     * @return LogDailySummary
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
     * @return LogDailySummary
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
     * Set device.
     *
     * @param \Queue\Entity\Device|null $device
     *
     * @return LogDailySummary
     */
    public function setDevice(\Queue\Entity\Device $device = null)
    {
        $this->device = $device;

        return $this;
    }

    /**
     * Get device.
     *
     * @return \Queue\Entity\Device|null
     */
    public function getDevice()
    {
        return $this->device;
    }
}
