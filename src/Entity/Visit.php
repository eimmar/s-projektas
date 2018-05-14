<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

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
     * @var \DateTime
     */
    private $visitDate;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\VisitStatus")
     * @ORM\JoinColumn(nullable=false)
     */
    private $status;

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
     * @ORM\OneToMany(targetEntity="App\Entity\ServiceHistory", mappedBy="visit")
     * @var ArrayCollection|ServiceHistory[]
     */
    protected $serviceHistories;

    public function __construct()
    {
        $this->serviceHistories = new ArrayCollection();
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
        return $this->visitDate;
    }

    /**
     * @param \DateTime $visitDate
     */
    public function setVisitDate(\DateTime $visitDate): self
    {
        $this->visitDate = $visitDate;
    }

    /**
     * @return mixed
     */
    public function getStatus(): VisitStatus
    {
        return $this->status;
    }

    /**
     * @param VisitStatus $statusId
     */
    public function setStatus($statusId): self
    {
        $this->status = $statusId;
    }

    /**
     * @return Collection|Config[]
     */
    public function getConfigsChanged(): Collection
    {
        return $this->serviceHistories;
    }

    public function addConfigsChanged(ServiceHistory $serviceHistory): self
    {
        if (!$this->serviceHistories->contains($serviceHistory)) {
            $this->serviceHistories[] = $serviceHistory;
            $serviceHistory->setVisit($this);
        }

        return $this;
    }

    public function removeConfigsChanged(ServiceHistory $serviceHistory): self
    {
        if ($this->serviceHistories->contains($serviceHistory)) {
            $this->serviceHistories->removeElement($serviceHistory);
            // set the owning side to null (unless already changed)
            if ($serviceHistory->getVisit() === $this) {
                $serviceHistory->setVisit(null);
            }
        }

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
