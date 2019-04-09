<?php

namespace App\Table;

use Pagerfanta\Pagerfanta;

/**
 * Class Table
 * @package App\Table
 */
class Table
{
    /** @var Pagerfanta */
    private $pager;

    /** @var string */
    private $defaultSortColumn = 'id';

    /** @var array */
    private $sortColumns = [];

    /** @var string */
    private $routeNamePrefix = '';

    /** @var array */
    private $view = [];

    /**
     * @return Pagerfanta
     */
    public function getPager(): Pagerfanta
    {
        return $this->pager;
    }

    /**
     * @param Pagerfanta $pager
     * @return Table
     */
    public function setPager(Pagerfanta $pager): Table
    {
        $this->pager = $pager;
        return $this;
    }

    /**
     * @return string
     */
    public function getDefaultSortColumn(): string
    {
        return $this->defaultSortColumn;
    }

    /**
     * @param string $defaultSortColumn
     * @return Table
     */
    public function setDefaultSortColumn(string $defaultSortColumn): Table
    {
        $this->defaultSortColumn = $defaultSortColumn;
        return $this;
    }

    /**
     * @return string
     */
    public function getRouteNamePrefix(): string
    {
        return $this->routeNamePrefix;
    }

    /**
     * @param string $routeNamePrefix
     * @return Table
     */
    public function setRouteNamePrefix(string $routeNamePrefix): Table
    {
        $this->routeNamePrefix = $routeNamePrefix;
        return $this;
    }

    /**
     * @return array
     */
    public function getView(): array
    {
        return $this->view;
    }

    /**
     * @param array $view
     * @return Table
     */
    public function setView(array $view): Table
    {
        $this->view = $view;
        return $this;
    }

    /**
     * @return array
     */
    public function getSortColumns(): array
    {
        return $this->sortColumns;
    }

    /**
     * @param array $sortColumns
     * @return Table
     */
    public function setSortColumns(array $sortColumns): Table
    {
        $this->sortColumns = $sortColumns;
        return $this;
    }
}