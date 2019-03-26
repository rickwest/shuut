<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\VehicleRepository")
 */
class Vehicle
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=32)
     */
    private $registration;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\VehicleType", inversedBy="vehicles")
     * @ORM\JoinColumn(nullable=false)
     */
    private $vehicleType;

    /**
     * @ORM\Column(type="decimal", precision=8, scale=2, nullable=true)
     */
    private $width;

    /**
     * @ORM\Column(type="decimal", precision=8, scale=2, nullable=true)
     */
    private $depth;

    /**
     * @ORM\Column(type="decimal", precision=8, scale=2, nullable=true)
     */
    private $height;

    /**
     * @ORM\Column(type="string", length=32)
     */
    private $make;

    /**
     * @ORM\Column(type="string", length=32)
     */
    private $model;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRegistration(): ?string
    {
        return $this->registration;
    }

    public function setRegistration(string $registration): self
    {
        $this->registration = $registration;

        return $this;
    }

    public function getVehicleType(): ?VehicleType
    {
        return $this->vehicleType;
    }

    public function setVehicleType(?VehicleType $vehicleType): self
    {
        $this->vehicleType = $vehicleType;

        return $this;
    }

    public function getWidth()
    {
        return $this->width;
    }

    public function setWidth($width): self
    {
        $this->width = $width;

        return $this;
    }

    public function getDepth(): ?\DateTimeInterface
    {
        return $this->depth;
    }

    public function setDepth(?\DateTimeInterface $depth): self
    {
        $this->depth = $depth;

        return $this;
    }

    public function getHeight()
    {
        return $this->height;
    }

    public function setHeight($height): self
    {
        $this->height = $height;

        return $this;
    }

    public function getMake(): ?string
    {
        return $this->make;
    }

    public function setMake(string $make): self
    {
        $this->make = $make;

        return $this;
    }

    public function getModel(): ?string
    {
        return $this->model;
    }

    public function setModel(string $model): self
    {
        $this->model = $model;

        return $this;
    }
}
