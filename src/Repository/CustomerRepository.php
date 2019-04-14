<?php

namespace App\Repository;

use App\Entity\Customer;
use App\Table\TableQueryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Customer|null find($id, $lockMode = null, $lockVersion = null)
 * @method Customer|null findOneBy(array $criteria, array $orderBy = null)
 * @method Customer[]    findAll()
 * @method Customer[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CustomerRepository extends ServiceEntityRepository implements TableQueryInterface
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Customer::class);
    }

    public function getTableQuery($sort, $order, $q = null)
    {
        $qb = $this->createQueryBuilder('c');

        if ($q) {
            $qb
                ->where('c.name LIKE :search')
                ->orWhere('c.accountRef LIKE :search')
                ->setParameter('search', '%' . $q . '%')
            ;
        }

        $qb->orderBy('c.' . $sort, $order);

        return $qb->getQuery();
    }
}
