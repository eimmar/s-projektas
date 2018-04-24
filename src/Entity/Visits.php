<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\VisitsRepository")
 */
class Visits
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     * @var int
     */
    private $id;

    /**
     * @ORM\Column(type="datetime", nullable=false)
     * @var \DateTime
     */
    private $visit_date;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Vehicles")
     * @ORM\JoinColumn(nullable=false)
     */
    private $vehicle_id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\VisitStatuses")
     * @ORM\JoinColumn(nullable=false)
     */
    private $status_id;

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

    public function __construct()
    {
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): Visits
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
     */
    public function setDateCreated(\DateTime $dateCreated): self
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
     */
    public function setDateUpdated(\DateTime $dateUpdated): self
    {
        $this->dateUpdated = $dateUpdated;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getVisitDate(): \DateTime
    {
        return $this->visit_date;
    }

    /**
     * @param \DateTime $visit_date
     */
    public function setVisitDate(\DateTime $visit_date): self
    {
        $this->visit_date = $visit_date;
    }

    /**
     * @return mixed
     */
    public function getVehicleId()
    {
        return $this->vehicle_id;
    }

    /**
     * @param mixed $vehicle_id
     */
    public function setVehicleId($vehicle_id): self
    {
        $this->vehicle_id = $vehicle_id;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getStatusId() :VisitStatuses
    {
        return $this->status_id;
    }

    /**
     * @param mixed $status_id
     */
    public function setStatusId($status_id): self
    {
        $this->status_id = $status_id;
    }

}