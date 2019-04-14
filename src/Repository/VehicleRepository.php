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

    public function getTableQuery($sort, $order, $q = null)
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
}
