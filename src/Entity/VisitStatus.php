<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\VisitStatusRepository")
 */
class VisitStatus
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     * @var int
     */
    private $id;

    /**
     * @ORM\Column(type="string", nullable=false, unique=true)
     * @var string
     */
    protected $name;

    /**
     * @ORM\Column(type="boolean", nullable=false)
     * @var bool
     */
    private $isResolved;

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
    public function setId(int $id): self
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return bool
     */
    public function isResolved()
    {
        return $this->isResolved;
    }

    /**
     * @param bool $isResolved
     * @return VisitStatus
     */
    public function setIsResolved(bool $isResolved)
    {
        $this->isResolved = $isResolved;
        return $this;
    }

    /**
     * @return null|string
     */
    public function __toString()
    {
        return $this->getName();
    }
}
