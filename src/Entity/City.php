<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CityRepository")
 */
class City
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @var int
     */
    private $id;

    /**
     * @ORM\Column(type="string", nullable=false, length=255)
     * @var string
     */
    private $name;

    /**
     * @ORM\ManyToOne(targetEntity="Country", inversedBy="cities")
     * @var Country
     */
    private $country;

    /**
     * @ORM\OneToMany(targetEntity="Address", mappedBy="city")
     * @var ArrayCollection
     */
    private $addresses;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\CompanyAddress", mappedBy="city")
     */
    private $companyAddresses;

    public function __construct()
    {
        $this->addresses = new ArrayCollection();
        $this->companyAddresses = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->getName();
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
     * @return City
     */
    public function setId(int $id): City
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return City
     */
    public function setName(string $name): City
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return Country
     */
    public function getCountry(): Country
    {
        return $this->country;
    }

    /**
     * @param Country $country
     * @return City
     */
    public function setCountry(Country $country): City
    {
        $this->country = $country;
        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getAddresses(): ArrayCollection
    {
        return $this->addresses;
    }

    /**
     * @param ArrayCollection $addresses
     * @return City
     */
    public function setAddresses(ArrayCollection $addresses): City
    {
        $this->addresses = $addresses;
        return $this;
    }

    /**
     * @param Address $address
     * @return $this
     */
    public function addAddress(Address $address)
    {
        if (!$this->addresses->contains($address)) {
            $this->addresses->add($address);
            $address->setCity($this);
        }
        return $this;
    }

    /**
     * @return Collection|CompanyAddress[]
     */
    public function getCompanyAddresses(): Collection
    {
        return $this->companyAddresses;
    }

    /**
     * @param CompanyAddress $companyAddress
     * @return City
     */
    public function addCompanyAddress(CompanyAddress $companyAddress): self
    {
        if (!$this->companyAddresses->contains($companyAddress)) {
            $this->companyAddresses[] = $companyAddress;
            $companyAddress->setCity($this);
        }

        return $this;
    }

    /**
     * @param CompanyAddress $companyAddress
     * @return City
     */
    public function removeCompanyAddress(CompanyAddress $companyAddress): self
    {
        if ($this->companyAddresses->contains($companyAddress)) {
            $this->companyAddresses->removeElement($companyAddress);
            if ($companyAddress->getCity() === $this) {
                $companyAddress->setCity(null);
            }
        }

        return $this;
    }
}
