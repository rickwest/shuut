<?php

namespace App\Entity;

use App\Table\Table;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Mapping\ClassMetadata;

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

    public function getDepth()
    {
        return $this->depth;
    }

    public function setDepth($depth): self
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

    public function __toString()
    {
        return $this->getRegistration();
    }

    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
        $metadata
            ->addPropertyConstraint('registration', new NotBlank())
            ->addPropertyConstraint('make', new NotBlank())
            ->addPropertyConstraint('model', new NotBlank())
            ->addPropertyConstraint('vehicleType', new NotBlank())
        ;
    }

    public static function setTableMetadata(Table $table)
    {
        $table
            ->setRouteNamePrefix('vehicle_')
            ->setSortColumns(['make', 'model', 'registration', 'vehicleType'])
            ->setView([
                'registration' => 'Registration',
                'vehicleType' => 'Type',
                'make' => 'Make',
                'model' => 'Model'
            ])
        ;
    }
}
