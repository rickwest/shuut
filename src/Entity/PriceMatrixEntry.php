<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Mapping\ClassMetadata;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PriceMatrixEntryRepository")
 */
class PriceMatrixEntry
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="decimal", precision=6, scale=2)
     */
    private $costPrice;

    /**
     * @ORM\Column(type="decimal", precision=6, scale=2)
     */
    private $salePrice;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\VehicleType")
     * @ORM\JoinColumn(nullable=false)
     */
    private $vehicleType;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\PriceMatrix", inversedBy="entries")
     * @ORM\JoinColumn(nullable=false)
     */
    private $priceMatrix;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCostPrice(): ?float
    {
        return $this->costPrice;
    }

    public function setCostPrice(float $costPrice): self
    {
        $this->costPrice = $costPrice;

        return $this;
    }

    public function getSalePrice(): ?float
    {
        return $this->salePrice;
    }

    public function setSalePrice(float $salePrice): self
    {
        $this->salePrice = $salePrice;

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

    public function getPriceMatrix(): ?PriceMatrix
    {
        return $this->priceMatrix;
    }

    public function setPriceMatrix(?PriceMatrix $priceMatrix): self
    {
        $this->priceMatrix = $priceMatrix;

        return $this;
    }

    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
        $metadata
            ->addPropertyConstraint('vehicleType', new NotBlank())
            ->addPropertyConstraint('salePrice', new NotBlank())
            ->addPropertyConstraint('costPrice', new NotBlank())
        ;
    }
}
