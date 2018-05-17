<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\VisitRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Visit
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
     * @Assert\NotBlank()
     * @var \DateTime
     */
    private $visitDate;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\VisitStatus")
     * @ORM\JoinColumn(nullable=false)
     * @Assert\NotBlank()
     */
    private $status;

    /**
     * @ORM\Column(type="datetime", nullable=false)
     * @var \DateTime
     */
    private $dateCreated;

    /**
     * @ORM\Column(type="datetime", nullable=false)
     * @var \DateTime
     */
    private $dateUpdated;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Vehicle")
     * @Assert\NotBlank()
     */
    private $vehicle;

    /**
     * @ORM\Column(type="decimal", scale=2, nullable=false)
     * @var float
     */
    private $totalInclTax;

    /**
     * @ORM\OneToMany(targetEntity="VisitService", mappedBy="visit")
     * @ORM\JoinColumn(nullable=false)
     * @Assert\NotBlank()
     */
    protected $visitServices;

    public function __construct()
    {
        $this->visitServices = new ArrayCollection();
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
    public function setId(int $id): Visit
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getDateCreated(): ?\DateTime
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
    public function getDateUpdated(): ?\DateTime
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
    public function getVisitDate(): ?\DateTime
    {
        return $this->visitDate;
    }

    /**
     * @param \DateTime $visitDate
     */
    public function setVisitDate(\DateTime $visitDate): self
    {
        $this->visitDate = $visitDate;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getStatus(): ?VisitStatus
    {
        return $this->status;
    }

    /**
     * @param VisitStatus $status
     */
    public function setStatus($status): self
    {
        $this->status = $status;
        return $this;
    }

    /**
     * @return float
     */
    public function getTotalInclTax(): ?float
    {
        return $this->totalInclTax;
    }

    /**
     * @param float $totalInclTax
     * @return Visit
     */
    public function setTotalInclTax(float $totalInclTax): Visit
    {
        $this->totalInclTax = $totalInclTax;
        return $this;
    }

    /**
     * @return Collection|Config[]
     */
    public function getVisitServices(): Collection
    {
        return $this->visitServices;
    }

    public function addVisitService(VisitService $visitService): self
    {
        if (!$this->visitServices->contains($visitService)) {
            $this->visitServices[] = $visitService;
            $visitService->setVisit($this);
        }

        return $this;
    }

    public function removeVisitService(VisitService $visitService): self
    {
        if ($this->visitServices->contains($visitService)) {
            $this->visitServices->removeElement($visitService);
            // set the owning side to null (unless already changed)
            if ($visitService->getVisit() === $this) {
                $visitService->setVisit(null);
            }
        }

        return $this;
    }

    /**
     * @return mixed
     */
    public function getVehicle()
    {
        return $this->vehicle;
    }

    /**
     * @param Vehicle $vehicle
     * @return Visit
     */
    public function setVehicle(?Vehicle $vehicle)
    {
        $this->vehicle = $vehicle;
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

    public function calculateTotals()
    {
        /** @var VisitService $service */
        foreach ($this->getVisitServices()->getValues() as $service) {
            $this->totalInclTax += $service->getPrice();
        }
    }

    /**
     * @return int
     */
    public function getTotalDuration()
    {
        $duration = 0;
        /** @var VisitService $service */
        foreach ($this->getVisitServices()->getValues() as $service) {
            $duration += $service->getDuration();
        };

        return $duration;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return (string) $this->getId();
    }
}
