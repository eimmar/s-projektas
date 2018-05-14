<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\VehicleRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Vehicle
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Model")
     * @ORM\JoinColumn(nullable=false)
     * @Assert\NotBlank()
     */
    private $model;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\Column(type="integer")
     * @Assert\NotBlank()
     * @Assert\Range(min="0")
     */
    private $powerKw;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\TransmissionType")
     * @ORM\JoinColumn(nullable=false)
     * @Assert\NotBlank()
     */
    private $transmissionType;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\FuelType")
     * @ORM\JoinColumn(nullable=false)
     * @Assert\NotBlank()
     */
    private $fuelType;

    /**
     * @ORM\Column(type="integer")
     * @Assert\NotBlank()
     * @Assert\Range(min="0")
     */
    private $engineCapacity;

    /**
     * @ORM\Column(type="integer")
     * @Assert\NotBlank()
     * @Assert\Range(min="1500")
     */
    private $yearMade;

    /**
     * @ORM\Column(type="integer")
     * @Assert\NotBlank()
     * @Assert\Range(min="1", max="12")
     */
    private $monthMade;

    /**
     * @ORM\Column(type="datetime")
     */
    private $dateCreated;

    /**
     * @ORM\Column(type="datetime")
     */
    private $dateUpdated;

    public function getId()
    {
        return $this->id;
    }

    public function getModel(): ?Model
    {
        return $this->model;
    }

    public function setModel(?Model $model): self
    {
        $this->model = $model;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getPowerKw(): ?int
    {
        return $this->powerKw;
    }

    public function setPowerKw(int $powerKw): self
    {
        $this->powerKw = $powerKw;

        return $this;
    }

    public function getTransmissionType(): ?TransmissionType
    {
        return $this->transmissionType;
    }

    public function setTransmissionType(?TransmissionType $transmissionType): self
    {
        $this->transmissionType = $transmissionType;

        return $this;
    }

    public function getFuelType(): ?FuelType
    {
        return $this->fuelType;
    }

    public function setFuelType(?FuelType $fuelType): self
    {
        $this->fuelType = $fuelType;

        return $this;
    }

    public function getEngineCapacity(): ?int
    {
        return $this->engineCapacity;
    }

    public function setEngineCapacity(int $engineCapacity): self
    {
        $this->engineCapacity = $engineCapacity;

        return $this;
    }

    public function getYearMade(): ?int
    {
        return $this->yearMade;
    }

    public function setYearMade(int $yearMade): self
    {
        $this->yearMade = $yearMade;

        return $this;
    }

    public function getMonthMade(): ?int
    {
        return $this->monthMade;
    }

    public function setMonthMade(int $monthMade): self
    {
        $this->monthMade = $monthMade;

        return $this;
    }

    public function getDateCreated(): ?\DateTimeInterface
    {
        return $this->dateCreated;
    }

    public function setDateCreated(\DateTimeInterface $dateCreated): self
    {
        $this->dateCreated = $dateCreated;

        return $this;
    }

    public function getDateUpdated(): ?\DateTimeInterface
    {
        return $this->dateUpdated;
    }

    public function setDateUpdated(\DateTimeInterface $dateUpdated): self
    {
        $this->dateUpdated = $dateUpdated;

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
}
