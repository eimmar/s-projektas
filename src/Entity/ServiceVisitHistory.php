<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ServiceRepository")
 * @ORM\HasLifecycleCallbacks
 */
class ServiceVisitHistory
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     * @var int
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Service")
     * @ORM\JoinColumn(nullable=false)
     */
    private $service_id;

    /**
     * @ORM\Column(type="float")
     * @Assert\NotBlank()
     */
    private $price;

    /**
     * @ORM\Column(type="string", length=65535, nullable=true)
     * @Assert\Length(max="65535")
     */
    private $description;

    /**
     * @ORM\Column(type="integer")
     * @Assert\NotBlank()
     * @Assert\Type(type="integer")
     */
    private $duration;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Visits")
     * @ORM\JoinColumn(nullable=false)
     */
    private $visit_id;

    /**
     * @ORM\Column(type="datetime", nullable=false)
     * @var \DateTime
     */
    private $visit_date;

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
     * @return mixed
     */
    public function getDuration(): ?int
    {
        return $this->duration;
    }

    /**
     * @param mixed $duration
     */
    public function setDuration($duration): self
    {
        $this->duration = $duration;
        return $$this;
    }

    /**
     * @param int $id
     * @return VisitStatuses
     */
    public function setId(int $id): VisitStatuses
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param mixed $service_id
     * @return VisitStatuses
     */
    public function setServiceId($service_id)
    {
        $this->service_id = $service_id;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getServiceId()
    {
        return $this->service_id;
    }

    /**
     * @param mixed $price
     * @return VisitStatuses
     */
    public function setPrice($price)
    {
        $this->price = $price;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * @param mixed $description
     * @return VisitStatuses
     */
    public function setDescription($description)
    {
        $this->description = $description;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param mixed $visit_id
     * @return VisitStatuses
     */
    public function setVisitId($visit_id)
    {
        $this->visit_id = $visit_id;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getVisitId()
    {
        return $this->visit_id;
    }

    /**
     * @param \DateTime $visit_date
     * @return VisitStatuses
     */
    public function setVisitDate(\DateTime $visit_date): VisitStatuses
    {
        $this->visit_date = $visit_date;
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
     * @param \DateTime $dateCreated
     * @return VisitStatuses
     */
    public function setDateCreated(\DateTime $dateCreated): VisitStatuses
    {
        $this->dateCreated = $dateCreated;
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
     * @param \DateTime $dateUpdated
     * @return VisitStatuses
     */
    public function setDateUpdated(\DateTime $dateUpdated): VisitStatuses
    {
        $this->dateUpdated = $dateUpdated;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getDateUpdated(): \DateTime
    {
        return $this->dateUpdated;
    }

}