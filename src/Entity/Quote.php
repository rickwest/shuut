<?php

namespace App\Entity;

use App\Table\Table;
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
     * @ORM\ManyToOne(targetEntity="App\Entity\VehicleType")
     * @ORM\JoinColumn(nullable=false)
     */
    private $vehicleType;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Distance", cascade={"persist", "remove"})
     */
    private $distance;

    /**
     * @ORM\Column(type="string", length=32)
     */
    private $status;

    public function __construct()
    {
        $this->lineItems = new ArrayCollection();
        $this->status = self::STATUS_INCOMPLETE;
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

        $this->setStatus(self::STATUS_ACCEPTED);

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function subtotal()
    {
        $subtotal = 0;
        foreach ($this->getLineItems() as $item) {
            $subtotal += $item->total();
        }
        return number_format($subtotal, 2);
    }

    public function vat()
    {
        return number_format($this->subtotal() * 0.2, 2);
    }

    public function total()
    {
        return number_format($this->subtotal() + $this->vat(), 2);
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

    public static function setTableMetadata(Table $table)
    {
        $table
            ->setRouteNamePrefix('quote_')
            ->setSortColumns(['customer', 'distance', 'status'])
            ->setView([
                'customer' => 'Customer',
                'pickUp' => 'Pick Up',
                'dropOff' => 'Drop Off',
                'distance' => 'Distance',
                'status' => 'Status',
            ])
        ;
    }
}
