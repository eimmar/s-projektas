<?php

namespace App\Entity;

use App\Traits\Slugable;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ServiceRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Service
{
    use Slugable;

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank()
     * @Assert\Length(max="255")
     */
    private $name;

    /**
     * @ORM\Column(type="text", length=16383, nullable=true)
     * @Assert\Length(max="16383")
     */
    private $description;

    /**
     * @ORM\Column(type="float")
     * @Assert\NotBlank()
     */
    private $priceFrom;

    /**
     * @ORM\Column(type="float")
     * @Assert\NotBlank()
     */
    private $priceTo;

    /**
     * @ORM\Column(type="integer")
     * @Assert\NotBlank()
     * @Assert\Type(type="integer")
     */
    private $durationFrom;

    /**
     * @ORM\Column(type="integer")
     * @Assert\NotBlank()
     * @Assert\Type(type="integer")
     */
    private $durationTo;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="services")
     */
    private $userCreatedBy;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\ServiceType", inversedBy="services")
     * @ORM\JoinColumn(nullable=false)
     * @Assert\NotBlank()
     */
    private $serviceType;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isActive;

    /**
     * @ORM\Column(type="datetime")
     */
    private $dateCreated;

    /**
     * @ORM\Column(type="datetime")
     */
    private $dateUpdated;

    /**
     * @return null|string
     */
    public function __toString()
    {
        return $this->getName();
    }

    public function getId()
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getPriceFrom(): ?float
    {
        return $this->priceFrom;
    }

    public function setPriceFrom(float $priceFrom): self
    {
        $this->priceFrom = $priceFrom;

        return $this;
    }

    public function getDurationFrom(): ?int
    {
        return $this->durationFrom;
    }

    public function setDurationFrom(int $durationFrom): self
    {
        $this->durationFrom = $durationFrom;

        return $this;
    }

    public function getDurationTo(): ?int
    {
        return $this->durationTo;
    }

    public function setDurationTo(int $durationTo): self
    {
        $this->durationTo = $durationTo;

        return $this;
    }

    public function getUserCreatedBy(): ?User
    {
        return $this->userCreatedBy;
    }

    public function setUserCreatedBy(?User $userCreatedBy): self
    {
        $this->userCreatedBy = $userCreatedBy;

        return $this;
    }

    public function getPriceTo(): ?float
    {
        return $this->priceTo;
    }

    public function setPriceTo(float $priceTo): self
    {
        $this->priceTo = $priceTo;

        return $this;
    }

    public function getIsActive(): ?bool
    {
        return $this->isActive;
    }

    public function setIsActive(bool $isActive): self
    {
        $this->isActive = $isActive;

        return $this;
    }

    public function getDateCreated(): ?\DateTime
    {
        return $this->dateCreated;
    }

    public function setDateCreated(\DateTime $dateCreated): self
    {
        $this->dateCreated = $dateCreated;

        return $this;
    }

    public function getDateUpdated(): ?\DateTime
    {
        return $this->dateUpdated;
    }

    public function setDateUpdated(\DateTime $dateUpdated): self
    {
        $this->dateUpdated = $dateUpdated;

        return $this;
    }

    /**
     * @return ServiceType
     */
    public function getServiceType()
    {
        return $this->serviceType;
    }

    /**
     * @param ServiceType $serviceType
     * @return Service
     */
    public function setServiceType(ServiceType $serviceType)
    {
        $this->serviceType = $serviceType;
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
            ->setDateUpdated(new \DateTime('now'));
    }

    /**
     * @return float|int
     */
    public function getPriceMedian()
    {
        return ($this->getPriceFrom() + $this->getPriceTo()) / 2;
    }

    /**
     * @return float|int
     */
    public function getDurationMedian()
    {
        return ($this->getDurationFrom() + $this->getDurationTo()) / 2;
    }
}
