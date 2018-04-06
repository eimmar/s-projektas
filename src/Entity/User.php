<?php

namespace App\Entity;
/**
 * Created by PhpStorm.
 * User: eimantas
 * Date: 18.4.4
 * Time: 22.23
 */
use Doctrine\ORM\Mapping\InheritanceType;
use \FOS\UserBundle\Model\User as FOSUser;
use Doctrine\ORM\Mapping as ORM;


/**
 * Class User
 * @InheritanceType("SINGLE_TABLE")
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 * @ORM\Table(name="users")
 */
class User extends FOSUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     * @var int
     */
    protected $id;

    /**
     * @ORM\Column(type="string", nullable=false)
     * @var string
     */
    protected $firstName;

    /**
     * @ORM\Column(type="string", nullable=true)
     * @var string|null
     */
    protected $lastName;

    /**
     * @ORM\Column(type="boolean", nullable=false)
     * @var bool
     */
    protected $isActive;

    /**
     * @ORM\Column(type="datetime", nullable=false)
     * @var \DateTime
     */
    protected $dateCreated;

    /**
     * @ORM\Column(type="datetime", nullable=false)
     * @var \DateTime
     */
    protected $dateUpdated;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return User
     */
    public function setId(int $id): User
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getDateCreated(): \DateTime
    {
        return $this->dateCreated;
    }

    /**
     * @param \DateTime $dateCreated
     * @return User
     */
    public function setDateCreated(\DateTime $dateCreated): User
    {
        $this->dateCreated = $dateCreated;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getDateUpdated(): \DateTime
    {
        return $this->dateUpdated;
    }

    /**
     * @param \DateTime $dateUpdated
     * @return User
     */
    public function setDateUpdated(\DateTime $dateUpdated): User
    {
        $this->dateUpdated = $dateUpdated;
        return $this;
    }

    /**
     * @return string
     */
    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    /**
     * @param string $firstName
     * @return User
     */
    public function setFirstName(?string $firstName): User
    {
        $this->firstName = $firstName;
        return $this;
    }

    /**
     * @return null|string
     */
    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    /**
     * @param null|string $lastName
     * @return User
     */
    public function setLastName(?string $lastName): User
    {
        $this->lastName = $lastName;
        return $this;
    }

    /**
     * @return bool
     */
    public function isActive(): bool
    {
        return $this->isActive;
    }

    /**
     * @param bool $isActive
     * @return User
     */
    public function setIsActive(bool $isActive): User
    {
        $this->isActive = $isActive;
        return $this;
    }

    /**
     * @ORM\PreUpdate
     */
    public function preUpdate()
    {
        $this->setDateUpdated(new \DateTime('now'));
    }

    /**
     * @ORM\PrePersist
     */
    public function prePersist()
    {
        $this->setDateCreated(new \DateTime('now'))
            ->setDateUpdated(new \DateTime('now'))
            ->setIsActive(true);
    }
}
