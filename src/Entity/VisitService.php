<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\VisitServiceRepository")
 * @ORM\HasLifecycleCallbacks
 */
class VisitService
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
     * @ORM\Column(type="string", length=255, nullable=false)
     * @Assert\Length(max="255")
     */
    private $name;

    /**
     * @ORM\Column(type="integer")
     * @Assert\NotBlank()
     * @Assert\Type(type="integer")
     */
    private $duration;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Visit", inversedBy="visitServices")
     * @ORM\JoinColumn(nullable=false)
     */
    private $visit;

    /**
     * @ORM\Column(type="integer", length=10, nullable=false)
     * @Assert\NotBlank()
     * @Assert\Length(min="1", max="10")
     */
    private $quantity;

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
        return $this;
    }

    /**
     * @param int $id
     * @return VisitService
     */
    public function setId(int $id): VisitService
    {
        $this->id = $id;
        return $this;
    }


    /**
     * @return int
     */
    public function getId(): ?int
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
     * @return VisitService
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
     * @return VisitService
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
     * @return VisitService
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
     * @return VisitService
     */
    public function setDateCreated(\DateTime $dateCreated): VisitService
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
     * @return VisitService
     */
    public function setDateUpdated(\DateTime $dateUpdated): VisitService
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
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     * @return VisitService
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getQuantity() :?int
    {
        return $this->quantity;
    }

    /**
     * @param int|null $quantity
     * @return VisitService
     */
    public function setQuantity(?int $quantity)
    {
        $this->quantity = $quantity;
        return $this;
    }

    /**
     * @return VisitService $this
     */
    public function incrementQuantity()
    {
        $this->quantity++;
        return $this;
    }

    /**
     * @return VisitService $this
     */
    public function decrementQuantity()
    {
        $this->quantity++;
        return $this;
    }

    /**
     * @param Service $service
     * @return VisitService
     */
    public function setService(Service $service)
    {
        $this->service = $service;
        $this->setDescription($service->getDescription())
            ->setDuration($service->getDurationMedian())
            ->setPrice($service->getPriceMedian())
            ->setName($service->getName())
            ->incrementQuantity();

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
     * @return string
     */
    public function __toString()
    {
        return (string) $this->getId();
    }
}
