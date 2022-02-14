<?php

namespace SparkLib\SparkQuery\Builder\Component;

use SparkLib\SparkQuery\Structure\Clause;

trait WhereBuilder
{

    /**
     * Array of Clause structure object created by Where manipulation class
     */
    private $where = [];

    /**
     * Interface Iwhere required method
     */
    public function getWhere(): array
    {
        return $this->where;
    }

    /**
     * Interface Iwhere required method
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
     * Interface Iwhere required method
     */
    public function countWhere(): int
    {
        return count($this->where);
    }

    /**
     * Interface Iwhere required method
     */
    public function addWhere(Clause $where)
    {
        $this->where[] = $where;
    }

}
