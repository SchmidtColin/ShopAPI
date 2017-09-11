<?php

namespace ShopBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Shops
 *
 * @ORM\Table(name="shops")
 * @ORM\Entity
 */
class Shops
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="UUID")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="interface_password", type="string", length=128, nullable=true)
     */
    private $interfacePassword;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="last_sync", type="datetime", nullable=true)
     */
    private $lastSync;

    /**
     * @var integer
     *
     * @ORM\Column(name="last_sync_response_code", type="integer", nullable=true)
     */
    private $lastSyncResponseCode;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="last_processed", type="datetime", nullable=true)
     */
    private $lastProcessed;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getInterfacePassword()
    {
        return $this->interfacePassword;
    }

    /**
     * @param string $interfacePassword
     */
    public function setInterfacePassword($interfacePassword)
    {
        $this->interfacePassword = $interfacePassword;
    }

    /**
     * @return \DateTime
     */
    public function getLastSync()
    {
        return $this->lastSync;
    }

    /**
     * @param \DateTime $lastSync
     */
    public function setLastSync($lastSync)
    {
        $this->lastSync = $lastSync;
    }

    /**
     * @return int
     */
    public function getLastSyncResponseCode()
    {
        return $this->lastSyncResponseCode;
    }

    /**
     * @param int $lastSyncResponseCode
     */
    public function setLastSyncResponseCode($lastSyncResponseCode)
    {
        $this->lastSyncResponseCode = $lastSyncResponseCode;
    }

    /**
     * @return \DateTime
     */
    public function getLastProcessed()
    {
        return $this->lastProcessed;
    }

    /**
     * @param \DateTime $lastProcessed
     */
    public function setLastProcessed($lastProcessed)
    {
        $this->lastProcessed = $lastProcessed;
    }


}

