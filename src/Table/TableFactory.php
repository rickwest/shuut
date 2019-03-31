<?php

namespace App\Table;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Query;
use Pagerfanta\Adapter\DoctrineORMAdapter;
use Pagerfanta\Pagerfanta;
use Symfony\Component\HttpFoundation\Request;

class TableFactory
{
    const NUM_ITEMS = 10;

    protected $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function getTable(Request $request, $entity)
    {
        $table = new Table();

        $query = $this->em->getRepository($entity)->getTableQuery(
            $request->get('sort', $entity::$tableMeta['sortColumn']),
            $request->get('order', 'ASC'),
            $request->get('q')
        );

        $table->pager = $this->createPaginator($query, $request->get('page', 1));
        $table->tableMeta = $entity::$tableMeta;

        return $table;
    }

    /**
     * Creates a Doctrine ORM paginator for the given query.
     *
     * @param Query $query
     * @param int $page
     * @param int $maxPerPage
     * @return Pagerfanta
     */
    public function createPaginator(Query $query, int $page, $maxPerPage = self::NUM_ITEMS): Pagerfanta
    {
        $paginator = new Pagerfanta(new DoctrineORMAdapter($query));
        $paginator->setMaxPerPage($maxPerPage);
        $paginator->setCurrentPage($page);
        return $paginator;
    }
}