<?php

namespace App\Repository;

use App\Entity\VehicleType;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method VehicleType|null find($id, $lockMode = null, $lockVersion = null)
 * @method VehicleType|null findOneBy(array $criteria, array $orderBy = null)
 * @method VehicleType[]    findAll()
 * @method VehicleType[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class VehicleTypeRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, VehicleType::class);
    }

    // /**
    //  * @return VehicleType[] Returns an array of VehicleType objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('v')
            ->andWhere('v.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('v.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?VehicleType
    {
        return $this->createQueryBuilder('v')
            ->andWhere('v.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
