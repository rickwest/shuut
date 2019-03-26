<?php

namespace App\Entity;

//use App\Form\Model\QuoteFormModel;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\QuoteRepository")
 */
class Quote
{
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
     * @ORM\ManyToOne(targetEntity="App\Entity\Address")
     * @ORM\JoinColumn(nullable=false)
     */
    private $pickUp;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Address", inversedBy="quotes")
     * @ORM\JoinColumn(nullable=false)
     */
    private $dropOff;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $notes;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\LineItem", mappedBy="quote")
     */
    private $lineItems;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Job", mappedBy="quote", cascade={"persist", "remove"})
     */
    private $job;

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

//    public static function createFromFormModel(QuoteFormModel $formModel) {
//       $quote = new self();
//       $quote->setDropOff($formModel->getDropOff());
//       $quote->setPickUp($formModel->getPickUp());
//       $quote->setNotes($formModel->getNotes());
//
//       foreach ($formModel->getFees() as $lineItem) {
//           $quote->addFee($lineItem);
//       }
//       return $quote;
//    }
}
