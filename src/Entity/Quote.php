<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Valid;
use Symfony\Component\Validator\Mapping\ClassMetadata;

/**
 * @ORM\Entity(repositoryClass="App\Repository\QuoteRepository")
 */
class Quote
{
    const STATUS_INCOMPLETE = 'Incomplete';
    const STATUS_COMPLETE = 'Complete';
    const STATUS_ACCEPTED = 'Accepted';

    public static $tableMeta = [
        'sortColumn' => 'id',
        'routeNamePrefix' => 'quote_',
        'view' => [
            'customer' => 'Customer',
            'pickUp' => 'Pick Up',
            'dropOff' => 'Drop Off',
            'status' => 'Status',
        ],
    ];

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Customer", inversedBy="quotes")
     * @ORM\JoinColumn(nullable=false)
     */
    private $customer;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Address", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $pickUp;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Address", inversedBy="quotes", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $dropOff;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $notes;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\LineItem", mappedBy="quote", cascade={"persist", "remove"})
     */
    private $lineItems;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Job", mappedBy="quote", cascade={"persist", "remove"})
     */
    private $job;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\VehicleType", inversedBy="quotes")
     * @ORM\JoinColumn(nullable=false)
     */
    private $vehicleType;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Distance", cascade={"persist", "remove"})
     */
    private $distance;

    public function __construct()
    {
        $this->lineItems = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCustomer(): ?Customer
    {
        return $this->customer;
    }

    public function setCustomer(?Customer $customer): self
    {
        $this->customer = $customer;

        return $this;
    }

    public function getPickUp(): ?Address
    {
        return $this->pickUp;
    }

    public function setPickUp(?Address $pickUp): self
    {
        $this->pickUp = $pickUp;

        return $this;
    }

    public function getDropOff(): ?Address
    {
        return $this->dropOff;
    }

    public function setDropOff(?Address $dropOff): self
    {
        $this->dropOff = $dropOff;

        return $this;
    }

    public function getNotes(): ?string
    {
        return $this->notes;
    }

    public function setNotes(?string $notes): self
    {
        $this->notes = $notes;

        return $this;
    }

    /**
     * @return Collection|LineItem[]
     */
    public function getLineItems(): Collection
    {
        return $this->lineItems;
    }

    public function addLineItem(LineItem $lineItem): self
    {
        if (!$this->lineItems->contains($lineItem)) {
            $this->lineItems[] = $lineItem;
            $lineItem->setQuote($this);
        }

        return $this;
    }

    public function removeLineItem(LineItem $lineItem): self
    {
        if ($this->lineItems->contains($lineItem)) {
            $this->lineItems->removeElement($lineItem);
            // set the owning side to null (unless already changed)
            if ($lineItem->getQuote() === $this) {
                $lineItem->setQuote(null);
            }
        }

        return $this;
    }

    public function getJob(): ?Job
    {
        return $this->job;
    }

    public function setJob(Job $job): self
    {
        $this->job = $job;

        // set the owning side of the relation if necessary
        if ($this !== $job->getQuote()) {
            $job->setQuote($this);
        }

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

    public function getDistance(): ?Distance
    {
        return $this->distance;
    }

    public function setDistance(?Distance $distance): self
    {
        $this->distance = $distance;

        return $this;
    }

    public function accept()
    {
        $this->setJob(new Job());

        return $this;
    }

    public function status()
    {
        if ($this->getLineItems()->isEmpty()) {
            return self::STATUS_INCOMPLETE;
        };

        if ($this->getJob()) {
            return self::STATUS_ACCEPTED;
        }

        return self::STATUS_COMPLETE;
    }

    public function getTotals() {
        return 'total';
    }

    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
        $metadata
            ->addPropertyConstraint('customer', new NotBlank())
            ->addPropertyConstraint('vehicleType', new NotBlank())
            ->addPropertyConstraint('pickUp', new Valid())
            ->addPropertyConstraint('dropOff', new Valid())
            ->addPropertyConstraint('lineItems', new Valid())
        ;
    }
}
