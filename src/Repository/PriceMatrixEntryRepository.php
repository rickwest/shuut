<?php

namespace App\Repository;

use App\Entity\PriceMatrixEntry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method PriceMatrixEntry|null find($id, $lockMode = null, $lockVersion = null)
 * @method PriceMatrixEntry|null findOneBy(array $criteria, array $orderBy = null)
 * @method PriceMatrixEntry[]    findAll()
 * @method PriceMatrixEntry[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PriceMatrixEntryRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, PriceMatrixEntry::class);
    }

    // /**
    //  * @return PriceMatrixEntry[] Returns an array of PriceMatrixEntry objects
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
    public function findOneBySomeField($value): ?PriceMatrixEntry
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
