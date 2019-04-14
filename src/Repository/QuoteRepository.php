<?php

namespace App\Repository;

use App\Entity\Quote;
use App\Table\TableQueryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Quote|null find($id, $lockMode = null, $lockVersion = null)
 * @method Quote|null findOneBy(array $criteria, array $orderBy = null)
 * @method Quote[]    findAll()
 * @method Quote[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class QuoteRepository extends ServiceEntityRepository implements TableQueryInterface
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Quote::class);
    }

    public function getTableQuery($sort, $order, $q = null)
    {
        $qb = $this->createQueryBuilder('q');

        $qb
            ->where('q.status = :incomplete')
            ->orWhere('q.status = :complete')
            ->setParameters([
                'incomplete' => Quote::STATUS_INCOMPLETE,
                'complete' => Quote::STATUS_COMPLETE,
            ])
        ;

        if ($q) {
            $qb
                ->join('q.customer', 'c')
                ->where('c.name LIKE :search')
                ->setParameter('search', '%' . $q . '%')
            ;
        }

        if ($sort === 'customer') {
            $qb->join('q.customer', 'c')->orderBy('c.name', $order);
        } elseif ($sort === 'distance')
            $qb->join('q.distance', 'd')->orderBy('d.distance', $order);
        else {
            $qb->orderBy('q.' . $sort, $order);
        }

        return $qb->getQuery();
    }
}
