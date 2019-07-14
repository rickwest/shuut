<?php

namespace App\Entity;

use App\Table\Table;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CustomerRepository")
 */
class Customer
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @Assert\NotBlank()
     * @Assert\Length(max="16")
     *
     * @ORM\Column(type="string", length=16)
     */
    private $accountRef;

    /**
     * @Assert\Length(max="64")
     *
     * @ORM\Column(type="string", length=64)
     */
    private $name;

    /**
     * @Assert\Valid()
     *
     * @ORM\OneToOne(targetEntity="App\Entity\Address", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $address;

    /**
     * @Assert\Length(max="32")
     *
     * @ORM\Column(type="string", length=32, nullable=true)
     */
    private $contactName;

    /**
     * @Assert\NotBlank()
     * @Assert\Length(max="32")
     *
     * @ORM\Column(type="string", length=32)
     */
    private $telephone;

    /**
     * @Assert\NotBlank()
     * @Assert\Length(max="128")
     * @Assert\Email()
     *
     * @ORM\Column(type="string", length=128)
     */
    private $email;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Quote", mappedBy="customer")
     */
    private $quotes;

    /**
     * @Assert\Length(max="32")
     *
     * @ORM\Column(type="string", length=32, nullable=true)
     */
    private $accountsTelephone;

    /**
     * @Assert\Length(max="128")
     * @Assert\Email()
     *
     * @ORM\Column(type="string", length=128, nullable=true)
     */
    private $accountsEmail;

    /**
     * @Assert\Length(max="32")
     *
     * @ORM\Column(type="string", length=32, nullable=true)
     */
    private $accountsContactName;

    /**
     * Customer constructor.
     */
    public function __construct()
    {
        $this->quotes = new ArrayCollection();
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return string|null
     */
    public function getAccountRef(): ?string
    {
        return $this->accountRef;
    }

    /**
     * @param string $accountRef
     * @return Customer
     */
    public function setAccountRef(string $accountRef): self
    {
        $this->accountRef = $accountRef;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return Customer
     */
    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Address|null
     */
    public function getAddress(): ?Address
    {
        return $this->address;
    }

    /**
     * @param Address $address
     * @return Customer
     */
    public function setAddress(Address $address): self
    {
        $this->address = $address;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getContactName(): ?string
    {
        return $this->contactName;
    }

    /**
     * @param string|null $contactName
     * @return Customer
     */
    public function setContactName(?string $contactName): self
    {
        $this->contactName = $contactName;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    /**
     * @param string $telephone
     * @return Customer
     */
    public function setTelephone(string $telephone): self
    {
        $this->telephone = $telephone;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * @param string $email
     * @return Customer
     */
    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getAccountsTelephone(): ?string
    {
        return $this->accountsTelephone;
    }

    /**
     * @param string|null $accountsTelephone
     * @return Customer
     */
    public function setAccountsTelephone(?string $accountsTelephone): self
    {
        $this->accountsTelephone = $accountsTelephone;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getAccountsEmail(): ?string
    {
        return $this->accountsEmail;
    }

    /**
     * @param string|null $accountsEmail
     * @return Customer
     */
    public function setAccountsEmail(?string $accountsEmail): self
    {
        $this->accountsEmail = $accountsEmail;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getAccountsContactName(): ?string
    {
        return $this->accountsContactName;
    }

    /**
     * @param string|null $accountsContactName
     * @return Customer
     */
    public function setAccountsContactName(?string $accountsContactName): self
    {
        $this->accountsContactName = $accountsContactName;

        return $this;
    }

    /**
     * @return Collection|Quote[]
     */
    public function getQuotes(): Collection
    {
        return $this->quotes;
    }

    /**
     * @param Quote $quote
     * @return Customer
     */
    public function addQuote(Quote $quote): self
    {
        if (!$this->quotes->contains($quote)) {
            $this->quotes[] = $quote;
            $quote->setCustomer($this);
        }

        return $this;
    }

    /**
     * @param Quote $quote
     * @return Customer
     */
    public function removeQuote(Quote $quote): self
    {
        if ($this->quotes->contains($quote)) {
            $this->quotes->removeElement($quote);
            // set the owning side to null (unless already changed)
            if ($quote->getCustomer() === $this) {
                $quote->setCustomer(null);
            }
        }

        return $this;
    }

    /**
     * @return string|null
     */
    public function __toString()
    {
        return $this->getName();
    }

    /**
     * @param Table $table
     */
    public static function setTableMetadata(Table $table)
    {
        $table
            ->setRouteNamePrefix('customer_')
            ->setSortColumns(['accountRef', 'name', 'contactName', 'email'])
            ->setView([
                'accountRef' => 'Account Ref',
                'name' => 'Name',
                'contactName' => 'Contact Name',
                'telephone' => 'Telephone',
                'email' => 'Email',
            ])
        ;
    }
}
