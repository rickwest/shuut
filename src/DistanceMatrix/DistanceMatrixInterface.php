<?php

namespace App\DistanceMatrix;

use App\Entity\Address;
use App\Entity\Distance;

/**
 * Interface DistanceMatrixInterface
 * @package App\DistanceMatrix
 */
interface DistanceMatrixInterface
{
    /**
     * @param Address $origin
     * @param Address $destination
     * @return Distance|null
     */
    public function getDistance(Address $origin, Address $destination);

    /**
     * @param Address $origin
     * @param Address $destination
     * @return string
     */
    public function getMap(Address $origin, Address $destination);
}