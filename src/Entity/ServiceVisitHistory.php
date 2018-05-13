<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ServiceVisitHistoryRepository")
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
    private $serviceId;

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
    private $visitId;

    /**
     * @ORM\Column(type="datetime", nullable=false)
     * @var \DateTime
     */
    private $visitDate;

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
     * @return ServiceVisitHistory
     */
    public function setId(int $id): ServiceVisitHistory
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
     * @return mixed
     */
    public function getServiceId()
    {
        return $this->serviceId;
    }

    /**
     * @param mixed $price
     * @return ServiceVisitHistory
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
     * @return ServiceVisitHistory
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
     * @param mixed $visitId
     * @return ServiceVisitHistory
     */
    public function setVisitId($visitId)
    {
        $this->visitId = $visitId;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getVisitId()
    {
        return $this->visitId;
    }

    /**
     * @param \DateTime $visitDate
     * @return ServiceVisitHistory
     */
    public function setVisitDate(\DateTime $visitDate): ServiceVisitHistory
    {
        $this->visitDate = $visitDate;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getVisitDate(): \DateTime
    {
        return $this->visitDate;
    }

    /**
     * @param \DateTime $dateCreated
     * @return ServiceVisitHistory
     */
    public function setDateCreated(\DateTime $dateCreated): ServiceVisitHistory
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
     * @return ServiceVisitHistory
     */
    public function setDateUpdated(\DateTime $dateUpdated): ServiceVisitHistory
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

    /**
     * @param mixed $service_id
     * @return ServiceVisitHistory
     */
    public function setServiceId($serviceId)
    {
        $this->serviceId = $serviceId;
        return $this;
    }

}