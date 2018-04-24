<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\VehiclesRepository")
 */
class Vehicles
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Models")
     * @ORM\JoinColumn(nullable=false)
     */
    private $model_id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user_id;

    /**
     * @ORM\Column(type="integer")
     */
    private $power_kw;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\TransmitionTypes")
     * @ORM\JoinColumn(nullable=false)
     */
    private $transmition_type_id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\FuelTypes")
     * @ORM\JoinColumn(nullable=false)
     */
    private $fuel_type_id;

    /**
     * @ORM\Column(type="integer")
     */
    private $engine_capacity;

    /**
     * @ORM\Column(type="integer")
     */
    private $year_made;

    /**
     * @ORM\Column(type="integer")
     */
    private $month_made;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date_created;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date_modified;

    public function getId()
    {
        return $this->id;
    }

    public function getModelId(): ?Models
    {
        return $this->model_id;
    }

    public function setModelId(?Models $model_id): self
    {
        $this->model_id = $model_id;

        return $this;
    }

    public function getUserId(): ?User
    {
        return $this->user_id;
    }

    public function setUserId(?User $user_id): self
    {
        $this->user_id = $user_id;

        return $this;
    }

    public function getPowerKw(): ?int
    {
        return $this->power_kw;
    }

    public function setPowerKw(int $power_kw): self
    {
        $this->power_kw = $power_kw;

        return $this;
    }

    public function getTransmitionTypeId(): ?TransmitionTypes
    {
        return $this->transmition_type_id;
    }

    public function setTransmitionTypeId(?TransmitionTypes $transmition_type_id): self
    {
        $this->transmition_type_id = $transmition_type_id;

        return $this;
    }

    public function getFuelTypeId(): ?FuelTypes
    {
        return $this->fuel_type_id;
    }

    public function setFuelTypeId(?FuelTypes $fuel_type_id): self
    {
        $this->fuel_type_id = $fuel_type_id;

        return $this;
    }

    public function getEngineCapacity(): ?int
    {
        return $this->engine_capacity;
    }

    public function setEngineCapacity(int $engine_capacity): self
    {
        $this->engine_capacity = $engine_capacity;

        return $this;
    }

    public function getYearMade(): ?int
    {
        return $this->year_made;
    }

    public function setYearMade(int $year_made): self
    {
        $this->year_made = $year_made;

        return $this;
    }

    public function getMonthMade(): ?int
    {
        return $this->month_made;
    }

    public function setMonthMade(int $month_made): self
    {
        $this->month_made = $month_made;

        return $this;
    }

    public function getDateCreated(): ?\DateTimeInterface
    {
        return $this->date_created;
    }

    public function setDateCreated(\DateTimeInterface $date_created): self
    {
        $this->date_created = $date_created;

        return $this;
    }

    public function getDateModified(): ?\DateTimeInterface
    {
        return $this->date_modified;
    }

    public function setDateModified(\DateTimeInterface $date_modified): self
    {
        $this->date_modified = $date_modified;

        return $this;
    }
}
