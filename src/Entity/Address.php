<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\AddressRepository")
 */
class Address
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @var int
     */
    private $id;

    /**
     * @ORM\Column(type="string", nullable=true, length=255)
     * @var string|null
     */
    private $street;

    /**
     * @ORM\Column(type="string", nullable=true, length=255)
     * @var string|null
     */
    private $comment;

    /**
     * @ORM\ManyToOne(targetEntity="City", inversedBy="addresses")
     * @var City
     */
    private $city;

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="addresses")
     * @var User
     */
    private $user;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return Address
     */
    public function setId(int $id): Address
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return null|string
     */
    public function getStreet(): ?string
    {
        return $this->street;
    }

    /**
     * @param null|string $street
     * @return Address
     */
    public function setStreet(?string $street): Address
    {
        $this->street = $street;
        return $this;
    }

    /**
     * @return null|string
     */
    public function getComment(): ?string
    {
        return $this->comment;
    }

    /**
     * @param null|string $comment
     * @return Address
     */
    public function setComment(?string $comment): Address
    {
        $this->comment = $comment;
        return $this;
    }

    /**
     * @return City
     */
    public function getCity(): City
    {
        return $this->city;
    }

    /**
     * @param City $city
     * @return Address
     */
    public function setCity(City $city): Address
    {
        $this->city = $city;
        return $this;
    }

    /**
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }

    /**
     * @param User $user
     * @return Address
     */
    public function setUser(User $user): Address
    {
        $this->user = $user;
        return $this;
    }
}
