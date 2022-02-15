<?php

namespace SparkLib\SparkQuery\Builder\Component;

use SparkLib\SparkQuery\Structure\Clause;

/**
 * Builder component for WHERE clause query
 */
trait WhereBuilder
{

    /**
     * Array of Clause structure object created by Where manipulation class
     */
    private $where = [];

    /**
     * Get list of where clause
     */
    public function getWhere(): array
    {
        return $this->where;
    }

    /**
     * Get last where clause in where list
     */
    public function lastWhere()
    {
        $len = count($this->where);
        if ($len > 0) {
            return $this->where[$len-1];
        } else {
            return null;
        }
    }

    /**
     * Count list of where clause
     */
    public function countWhere(): int
    {
        return count($this->where);
    }

    /**
     * Add a where clause to where list
     */
    public function addWhere(Clause $where)
    {
        $this->where[] = $where;
    }

}
