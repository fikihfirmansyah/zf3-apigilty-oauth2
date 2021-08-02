<?php

namespace Queue\Entity;

use Aqilix\ORM\Entity\EntityInterface;

/**
 * Log
 */
class Log implements EntityInterface
{
    /**
     * @var string
     */
    private $number;

    /**
     * @var string
     */
    private $counterNumber;

    /**
     * @var \DateTime
     */
    private $reservedTime;

    /**
     * @var \DateTime|null
     */
    private $calledTime;

    /**
     * @var \DateTime|null
     */
    private $endTime;

    /**
     * @var float|null
     */
    private $processingTime;

    /**
     * @var float|null
     */
    private $waitingTime;

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
     * @var \Doctrine\Common\Collections\Collection
     */
    private $summaries;


    /**
     * Constructor
     */
    public function __construct()
    {
        $this->summaries = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set number.
     *
     * @param string $number
     *
     * @return Log
     */
    public function setNumber($number)
    {
        $this->number = $number;

        return $this;
    }

    /**
     * Get number.
     *
     * @return string
     */
    public function getNumber()
    {
        return $this->number;
    }

    /**
     * Set counterNumber.
     *
     * @param string $counterNumber
     *
     * @return Log
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
     * Set reservedTime.
     *
     * @param \DateTime|null $reservedTime
     *
     * @return Log
     */
    public function setReservedTime($reservedTime)
    {
        $this->reservedTime = $reservedTime;

        return $this;
    }

    /**
     * Get reservedTime.
     *
     * @return \DateTime|null
     */
    public function getReservedTime()
    {
        return $this->reservedTime;
    }

    /**
     * Set calledTime.
     *
     * @param \DateTime|null $calledTime
     *
     * @return Log
     */
    public function setCalledTime($calledTime)
    {
        $this->calledTime = $calledTime;

        return $this;
    }

    /**
     * Get calledTime.
     *
     * @return \DateTime|null
     */
    public function getCalledTime()
    {
        return $this->calledTime;
    }

    /**
     * Set endTime.
     *
     * @param \DateTime $endTime
     *
     * @return Log
     */
    public function setEndTime($endTime)
    {
        $this->endTime = $endTime;

        return $this;
    }

    /**
     * Get endTime.
     *
     * @return \DateTime
     */
    public function getEndTime()
    {
        return $this->endTime;
    }

    /**
     * Set processingTime.
     *
     * @param float $processingTime
     *
     * @return Log
     */
    public function setProcessingTime($processingTime)
    {
        $this->processingTime = $processingTime;

        return $this;
    }

    /**
     * Get processingTime.
     *
     * @return float
     */
    public function getProcessingTime()
    {
        return $this->processingTime;
    }

    /**
     * Set waitingTime.
     *
     * @param float $waitingTime
     *
     * @return Log
     */
    public function setWaitingTime($waitingTime)
    {
        $this->waitingTime = $waitingTime;

        return $this;
    }

    /**
     * Get avgWaitingTime.
     *
     * @return float
     */
    public function getWaitingTime()
    {
        return $this->waitingTime;
    }

    /**
     * Set createdAt.
     *
     * @param \DateTime $createdAt
     *
     * @return Log
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
     * @return Log
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
     * @return Log
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
     * @return Log
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

    /**
     * Add summary.
     *
     * @param \Queue\Entity\LogDailySummary $summary
     *
     * @return Device
     */
    public function addSummary(\Queue\Entity\LogDailySummary $summary)
    {
        $this->summaries[] = $summary;

        return $this;
    }

    /**
     * Remove summary.
     *
     * @param \Queue\Entity\LogDailySummary $summary
     *
     * @return boolean TRUE if this collection contained the specified element, FALSE otherwise.
     */
    public function removeSummary(\Queue\Entity\LogDailySummary $summary)
    {
        return $this->summaries->removeElement($summary);
    }

    /**
     * Get summaries.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getSummaries()
    {
        return $this->summaries;
    }
}
