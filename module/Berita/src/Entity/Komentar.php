<?php

namespace Berita\Entity;

use Aqilix\ORM\Entity\EntityInterface;

/**
 * Komentar
 */
class Komentar implements EntityInterface
{
    /**
     * @var string
     */
    private $komentar;

    /**
     * @var string
     */
    private $penulis;

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
     * @var \Berita\Entity\Konten
     */
    private $konten;


    /**
     * Set komentar.
     *
     * @param string $komentar
     *
     * @return Komentar
     */
    public function setKomentar($komentar)
    {
        $this->komentar = $komentar;

        return $this;
    }

    /**
     * Get komentar.
     *
     * @return string
     */
    public function getKomentar()
    {
        return $this->komentar;
    }

    /**
     * Set penulis.
     *
     * @param string $penulis
     *
     * @return Komentar
     */
    public function setPenulis($penulis)
    {
        $this->penulis = $penulis;

        return $this;
    }

    /**
     * Get penulis.
     *
     * @return string
     */
    public function getPenulis()
    {
        return $this->penulis;
    }

    /**
     * Set createdAt.
     *
     * @param \DateTime $createdAt
     *
     * @return Komentar
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
     * @return Komentar
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
     * @return Komentar
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
     * Set konten.
     *
     * @param \Berita\Entity\Konten|null $konten
     *
     * @return Komentar
     */
    public function setKonten(\Berita\Entity\Konten $konten = null)
    {
        $this->konten = $konten;

        return $this;
    }

    /**
     * Get konten.
     *
     * @return \Berita\Entity\Konten|null
     */
    public function getKonten()
    {
        return $this->konten;
    }
}
