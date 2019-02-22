<?php

namespace App\Entity;

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
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $vehicleTypeId;

    /**
     * @ORM\Column(type="string", length=126)
     */
    private $name;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $costPerMile;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getVehicleTypeId(): ?int
    {
        return $this->vehicleTypeId;
    }

    public function setVehicleTypeId(int $vehicleTypeId): self
    {
        $this->vehicleTypeId = $vehicleTypeId;

        return $this;
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
}
