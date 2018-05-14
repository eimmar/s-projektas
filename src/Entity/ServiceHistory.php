<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ServiceHistoryRepository")
 * @ORM\HasLifecycleCallbacks
 */
class ServiceHistory
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
    private $service;

    /**
     * @ORM\Column(type="float")
     * @Assert\NotBlank()
     */
    private $price;

    /**
     * @ORM\Column(type="text", length=16383, nullable=true)
     * @Assert\Length(max="16383")
     */
    private $description;

    /**
     * @ORM\Column(type="integer")
     * @Assert\NotBlank()
     * @Assert\Type(type="integer")
     */
    private $duration;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Visit", inversedBy="serviceHistories")
     * @ORM\JoinColumn(nullable=false)
     */
    private $visit;

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
     * @return ServiceHistory
     */
    public function setId(int $id): ServiceHistory
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
     * @return Service
     */
    public function getService()
    {
        return $this->service;
    }

    /**
     * @param mixed $price
     * @return ServiceHistory
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
     * @return ServiceHistory
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
     * @param Visit|null $visit
     * @return ServiceHistory
     */
    public function setVisit(?Visit $visit)
    {
        $this->visit = $visit;
        return $this;
    }

    /**
     * @return Visit
     */
    public function getVisit()
    {
        return $this->visit;
    }

    /**
     * @param \DateTime $dateCreated
     * @return ServiceHistory
     */
    public function setDateCreated(\DateTime $dateCreated): ServiceHistory
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
     * @return ServiceHistory
     */
    public function setDateUpdated(\DateTime $dateUpdated): ServiceHistory
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
     * @param Service $service
     * @return ServiceHistory
     */
    public function setService(Service $service)
    {
        $this->service = $service;
        return $this;
    }
}
