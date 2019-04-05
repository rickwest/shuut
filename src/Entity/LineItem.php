<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Mapping\ClassMetadata;

/**
 * @ORM\Entity(repositoryClass="App\Repository\LineItemRepository")
 */
class LineItem
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="integer")
     */
    private $quantity;

    /**
     * @ORM\Column(type="decimal", precision=6, scale=2)
     */
    private $rate;

    /**
     * @ORM\Column(type="boolean")
     */
    private $vatable = true;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Quote", inversedBy="lineItems")
     * @ORM\JoinColumn(nullable=false)
     */
    private $quote;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): self
    {
        $this->quantity = $quantity;

        return $this;
    }

    public function getRate()
    {
        return $this->rate;
    }

    public function setRate($rate): self
    {
        $this->rate = $rate;

        return $this;
    }

    public function getVatable(): ?bool
    {
        return $this->vatable;
    }

    public function setVatable(bool $vatable): self
    {
        $this->vatable = $vatable;

        return $this;
    }

    /**
     * @return Quote
     */
    public function getQuote()
    {
        return $this->quote;
    }

    /**
     * @param Quote $quote
     * @return LineItem
     */
    public function setQuote($quote)
    {
        $this->quote = $quote;
        return $this;
    }

    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
        $metadata
            ->addPropertyConstraint('quantity', new NotBlank())
            ->addPropertyConstraint('rate', new NotBlank())
        ;
    }
}
