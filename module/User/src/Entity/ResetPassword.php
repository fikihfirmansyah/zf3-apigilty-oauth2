<?php

namespace User\Entity;

use Aqilix\ORM\Entity\EntityInterface;

/**
 * ResetPassword
 */
class ResetPassword implements EntityInterface
{
    /**
     * @var \DateTime
     */
    private $expiration;

    /**
     * @var \DateTime|null
     */
    private $reseted;

    /**
     * @var string|null
     */
    private $password;

    /**
     * @var \DateTime|null
     */
    private $createdAt;

    /**
     * @var \DateTime|null
     */
    private $updatedAt;

    /**
     * @var \DateTime|null
     */
    private $deletedAt;

    /**
     * @var string
     */
    private $uuid;

    /**
     * @var \Aqilix\OAuth2\Entity\OauthUsers
     */
    private $user;


    /**
     * Set expiration.
     *
     * @param \DateTime $expiration
     *
     * @return ResetPassword
     */
    public function setExpiration($expiration)
    {
        $this->expiration = $expiration;

        return $this;
    }

    /**
     * Get expiration.
     *
     * @return \DateTime
     */
    public function getExpiration()
    {
        return $this->expiration;
    }

    /**
     * Set reseted.
     *
     * @param \DateTime|null $reseted
     *
     * @return ResetPassword
     */
    public function setReseted($reseted = null)
    {
        $this->reseted = $reseted;

        return $this;
    }

    /**
     * Get reseted.
     *
     * @return \DateTime|null
     */
    public function getReseted()
    {
        return $this->reseted;
    }

    /**
     * Set password.
     *
     * @param string|null $password
     *
     * @return ResetPassword
     */
    public function setPassword($password = null)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get password.
     *
     * @return string|null
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set createdAt.
     *
     * @param \DateTime|null $createdAt
     *
     * @return ResetPassword
     */
    public function setCreatedAt($createdAt = null)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt.
     *
     * @return \DateTime|null
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set updatedAt.
     *
     * @param \DateTime|null $updatedAt
     *
     * @return ResetPassword
     */
    public function setUpdatedAt($updatedAt = null)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Get updatedAt.
     *
     * @return \DateTime|null
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
     * @return ResetPassword
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
     * Set user.
     *
     * @param \Aqilix\OAuth2\Entity\OauthUsers|null $user
     *
     * @return ResetPassword
     */
    public function setUser(\Aqilix\OAuth2\Entity\OauthUsers $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user.
     *
     * @return \Aqilix\OAuth2\Entity\OauthUsers|null
     */
    public function getUser()
    {
        return $this->user;
    }
}
