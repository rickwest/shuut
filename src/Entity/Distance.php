<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\DistanceRepository")
 */
class Distance
{
    const METRES_TO_MILES = 1609.34;

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $distance;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $duration;

    /**
     * Distance constructor.
     * @param int $distance
     * @param null $duration
     */
    public function __construct(int $distance, $duration = null)
    {
        $this->distance = $distance;
        $this->duration = $duration;
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return int
     */
    public function getDistance(): int
    {
        return $this->distance;
    }

    /**
     * @return int|null
     */
    public function getDuration(): ?int
    {
        return $this->duration;
    }

    /**
     * @return float
     */
    public function distanceMiles()
    {
        return round($this->distance / self::METRES_TO_MILES, 1);
    }

    /**
     * @return string
     */
    public function distanceText()
    {
        return $this->distanceMiles() . ' miles';
    }

    /**
     * @return array|void
     */
    public function durationHoursMinutes()
    {
        if (! $seconds = $this->getDuration()) return;

        return [ floor($seconds / 3600), floor(($seconds / 60) % 60) ];
    }

    /**
     * @return string|void
     */
    public function durationText()
    {
        if (! $this->getDuration()) return;

        list($hours, $minutes) = $this->durationHoursMinutes();

        return $hours > 0 ? $hours . ' hours ' . $minutes . ' minutes' : $minutes . ' minutes';
    }

    public function __toString()
    {
        return $this->distanceText();
    }
}
