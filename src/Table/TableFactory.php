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
        $repository = $this->em->getRepository($entity);

        if (! $repository instanceof TableQueryInterface) {
            throw new \Exception('Trying to get a table for entity: ' . $entity . ' but repository does not implement ' . TableQueryInterface::class);
        };

        $table = new Table();

        if (method_exists($entity,'setTableMetadata')) {
            $entity::setTableMetadata($table);
        }

        $query = $repository->getTableQuery(
            $request->get('sort', $table->getDefaultSortColumn()),
            $request->get('order', 'ASC'),
            $request->get('q')
        );

        $table->setPager($this->createPaginator($query, $request->get('page', 1)));

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