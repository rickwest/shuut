<?php

namespace App\Repository;

use App\Entity\Job;
use App\Table\TableQueryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Job|null find($id, $lockMode = null, $lockVersion = null)
 * @method Job|null findOneBy(array $criteria, array $orderBy = null)
 * @method Job[]    findAll()
 * @method Job[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class JobRepository extends ServiceEntityRepository implements TableQueryInterface
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Job::class);
    }

    public function getTableQuery($sort, $order, $q = null) {
        $qb = $this->createQueryBuilder('j');

//        $qb
//            ->where('q.status = :incomplete')
//            ->orWhere('q.status = :complete')
//            ->setParameters([
//                'incomplete' => Quote::STATUS_INCOMPLETE,
//                'complete' => Quote::STATUS_COMPLETE,
//            ])
//        ;
//
//        if ($q) {
//            $qb
//                ->join('q.customer', 'c')
//                ->where('c.name LIKE :search')
//                ->setParameter('search', '%' . $q . '%')
//            ;
//        }
//
//        if ($sort === 'customer') {
//            $qb->join('q.customer', 'c')->orderBy('c.name', $order);
//        } elseif ($sort === 'distance')
//            $qb->join('q.distance', 'd')->orderBy('d.distance', $order);
//        else {
//            $qb->orderBy('q.' . $sort, $order);
//        }

        return $qb->getQuery();




    }

    // /**
    //  * @return Job[] Returns an array of Job objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('j')
            ->andWhere('j.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('j.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Job
    {
        return $this->createQueryBuilder('j')
            ->andWhere('j.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
