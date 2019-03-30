<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\VehicleTypeRepository")
 */
class VehicleType
{
    const SMALL_VAN = 1;
    const SWB = 2;
    const LWB = 3;
    const LUTON = 4;
    const SEVEN_HALF_TONNE = 5;
    const SPECIAL = 6;

    /**
     * @ORM\Id()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=126)
     */
    private $name;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $costPerMile;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Vehicle", mappedBy="vehicleType")
     */
    private $vehicles;

    public function __construct(int $id)
    {
        $this->id = $id;
        $this->vehicles = new ArrayCollection();
    }

    public function getId(): ?int
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

    public function getCostPerMile(): ?float
    {
        return $this->costPerMile;
    }

    public function setCostPerMile(?float $costPerMile): self
    {
        $this->costPerMile = $costPerMile;

        return $this;
    }

    /**
     * @return Collection|Vehicle[]
     */
    public function getVehicles(): Collection
    {
        return $this->vehicles;
    }

    public function addVehicle(Vehicle $vehicle): self
    {
        if (!$this->vehicles->contains($vehicle)) {
            $this->vehicles[] = $vehicle;
            $vehicle->setVehicleType($this);
        }

        return $this;
    }

    public function removeVehicle(Vehicle $vehicle): self
    {
        if ($this->vehicles->contains($vehicle)) {
            $this->vehicles->removeElement($vehicle);
            // set the owning side to null (unless already changed)
            if ($vehicle->getVehicleType() === $this) {
                $vehicle->setVehicleType(null);
            }
        }

        return $this;
    }
}
