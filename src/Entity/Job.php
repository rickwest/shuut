<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\JobRepository")
 */
class Job
{
    const STATUS_IN_PROGRESS = 'In Progress';
    const STATUS_COMPLETE = 'Complete';
    const STATUS_CANCELLED = 'Cancelled';

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Quote", inversedBy="job", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $quote;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Vehicle")
     */
    private $vehicle;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Driver", inversedBy="jobs")
     */
    private $driver;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $date;

    /**
     * @ORM\Column(type="string", length=32)
     */
    private $status;

    public function __construct()
    {
        $this->status = self::STATUS_IN_PROGRESS;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQuote(): ?Quote
    {
        return $this->quote;
    }

    public function setQuote(Quote $quote): self
    {
        $this->quote = $quote;

        return $this;
    }

    public function getVehicle(): ?Vehicle
    {
        return $this->vehicle;
    }

    public function setVehicle(?Vehicle $vehicle): self
    {
        $this->vehicle = $vehicle;

        return $this;
    }

    public function getDriver(): ?Driver
    {
        return $this->driver;
    }

    public function setDriver(?Driver $driver): self
    {
        $this->driver = $driver;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(?\DateTimeInterface $date): self
    {
        $this->date = $date;

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

    public function complete()
    {
        $this->setStatus(self::STATUS_COMPLETE);

        return $this;
    }

    public function cancel()
    {
        $this->setStatus(self::STATUS_CANCELLED);

        return $this;
    }

    public function canBeCompleted()
    {
        return $this->getDriver() && $this->getVehicle();
    }

    public function isComplete()
    {
        return $this->getStatus() === self::STATUS_COMPLETE;
    }

    public function canBeCancelled()
    {
        return $this->getStatus() !== self::STATUS_COMPLETE;
    }
}
