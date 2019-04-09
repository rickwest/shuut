<?php

namespace App\Table;

use Doctrine\ORM\Query;

/**
 * Interface TableQueryInterface
 * @package App\Table
 */
interface TableQueryInterface
{
    /**
     * @param string $sort
     * @param string $order
     * @param string|null $q
     * @return Query
     */
    public function getTableQuery(string $sort, string $order, $q = null);
}