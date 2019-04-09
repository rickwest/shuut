<?php

namespace App\Repository;

use App\Entity\Vehicle;
use App\Table\TableQueryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Vehicle|null find($id, $lockMode = null, $lockVersion = null)
 * @method Vehicle|null findOneBy(array $criteria, array $orderBy = null)
 * @method Vehicle[]    findAll()
 * @method Vehicle[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class VehicleRepository extends ServiceEntityRepository implements TableQueryInterface
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Vehicle::class);
    }

    public function getTableQuery(string $sort, string $order, $q = null)
    {
        $qb = $this->createQueryBuilder('v');

        if ($q) {
            $qb
                ->where('v.registration LIKE :search')
                ->setParameter('search', '%' . $q . '%')
            ;
        }

        if ($sort === 'vehicleType') {
            $qb->join('v.vehicleType', 't')->orderBy('t.id', $order);
        } else {
            $qb->orderBy('v.' . $sort, $order);
        }

        return $qb->getQuery();
    }

    // /**
    //  * @return Vehicle[] Returns an array of Vehicle objects
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
    public function findOneBySomeField($value): ?Vehicle
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
