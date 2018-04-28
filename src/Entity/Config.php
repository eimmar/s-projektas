<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ConfigRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Config
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Length(max="255")
     * @Assert\NotBlank()
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\Length(max="255")
     */
    private $value;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\Length(max="255")
     */
    private $description;

    /**
     * @ORM\Column(type="datetime")
     */
    private $dateCreated;

    /**
     * @ORM\Column(type="datetime")
     */
    private $dateUpdated;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="configsChanged")
     */
    private $userChangedBy;

    /**
     * @return string
     */
    public function __toString(): string
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

    public function getValue(): ?string
    {
        return $this->value;
    }

    public function setValue(?string $value): self
    {
        $this->value = $value;

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

    public function getUserChangedBy(): ?User
    {
        return $this->userChangedBy;
    }

    public function setUserChangedBy(?User $userChangedBy): self
    {
        $this->userChangedBy = $userChangedBy;

        return $this;
    }

    /**
     * @ORM\PrePersist()
     */
    public function prePersist()
    {
        $this->setDateCreated(new \DateTime())
            ->setDateUpdated(new \DateTime());
    }

    /**
     * @ORM\PreUpdate()
     */
    public function preUpdate()
    {
        $this->setDateUpdated(new \DateTime());
    }
}
