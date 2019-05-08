<?php

namespace App\Repository;

use App\Entity\PriceMatrix;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method PriceMatrix|null find($id, $lockMode = null, $lockVersion = null)
 * @method PriceMatrix|null findOneBy(array $criteria, array $orderBy = null)
 * @method PriceMatrix[]    findAll()
 * @method PriceMatrix[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PriceMatrixRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, PriceMatrix::class);
    }

    // /**
    //  * @return PriceMatrix[] Returns an array of PriceMatrix objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?PriceMatrix
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
