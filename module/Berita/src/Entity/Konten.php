<?php

namespace Berita\Entity;

use Aqilix\ORM\Entity\EntityInterface;

/**
 * Konten
 */
class Konten implements EntityInterface
{
    /**
     * @var string
     */
    private $judul;

    /**
     * @var string
     */
    private $isi;

    /**
     * @var string
     */
    private $penulis;

    /**
     * @var string
     */
    private $kategori;

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
     * Set judul.
     *
     * @param string $judul
     *
     * @return Konten
     */
    public function setJudul($judul)
    {
        $this->judul = $judul;

        return $this;
    }

    /**
     * Get judul.
     *
     * @return string
     */
    public function getJudul()
    {
        return $this->judul;
    }

    /**
     * Set isi.
     *
     * @param string $isi
     *
     * @return Konten
     */
    public function setIsi($isi)
    {
        $this->isi = $isi;

        return $this;
    }

    /**
     * Get isi.
     *
     * @return string
     */
    public function getIsi()
    {
        return $this->isi;
    }

    /**
     * Set penulis.
     *
     * @param string $penulis
     *
     * @return Konten
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
     * Set kategori.
     *
     * @param string $kategori
     *
     * @return Konten
     */
    public function setKategori($kategori)
    {
        $this->kategori = $kategori;

        return $this;
    }

    /**
     * Get kategori.
     *
     * @return string
     */
    public function getKategori()
    {
        return $this->kategori;
    }

    /**
     * Set createdAt.
     *
     * @param \DateTime $createdAt
     *
     * @return Konten
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
     * @return Konten
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
     * @return Konten
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
