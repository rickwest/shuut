<?php

namespace App\Repository;

use App\Entity\Distance;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Distance|null find($id, $lockMode = null, $lockVersion = null)
 * @method Distance|null findOneBy(array $criteria, array $orderBy = null)
 * @method Distance[]    findAll()
 * @method Distance[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DistanceRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Distance::class);
    }
}
