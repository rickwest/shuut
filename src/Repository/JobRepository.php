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

        $qb
            ->where('j.status = :incomplete')
            ->orWhere('j.status = :complete')
            ->setParameters([
                'complete' => Job::STATUS_COMPLETE,
                'incomplete' => Job::STATUS_IN_PROGRESS,
            ])
        ;

        return $qb->getQuery();
    }
}
