<?php

namespace App\Repository;

use App\Entity\Driver;
use App\Table\TableQueryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Driver|null find($id, $lockMode = null, $lockVersion = null)
 * @method Driver|null findOneBy(array $criteria, array $orderBy = null)
 * @method Driver[]    findAll()
 * @method Driver[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DriverRepository extends ServiceEntityRepository implements TableQueryInterface
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Driver::class);
    }

    public function getTableQuery(string $sort, string $order, $q = null)
    {
        $qb = $this->createQueryBuilder('d');

        if ($q) {
            $qb
                ->where('d.name LIKE :search')
                ->orWhere('d.tradingName LIKE :search')
                ->setParameter('search', '%' . $q . '%')
            ;
        }

        $qb->orderBy('d.' . $sort, $order);

        return $qb->getQuery();
    }

    // /**
    //  * @return Driver[] Returns an array of Driver objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('d.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Driver
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
