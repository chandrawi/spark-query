<?php

namespace SparkLib\SparkQuery\Query\Component;

use SparkLib\SparkQuery\Structure\Join;

trait JoinTable
{

    /**
     * Create join table object from input table
     */
    private function setJoinTable($joinTable, int $joinType)
    {
        $joinObject = Join::create($joinTable, $joinType);
        $this->builder->addJoin($joinObject);
        return $this;
    }

    /** INNER JOIN query manipulation method */
    public function innerJoin($joinTable)
    {
        return $this->setJoinTable($joinTable, Join::INNER_JOIN);
    }

    /** LEFT JOIN query manipulation method */
    public function leftJoin($joinTable)
    {
        return $this->setJoinTable($joinTable, Join::LEFT_JOIN);
    }

    /** RIGHT JOIN query manipulation method */
    public function rightJoin(string $joinTable)
    {
        return $this->setJoinTable($joinTable, Join::RIGHT_JOIN);
    }

    /** OUTER JOIN query manipulation method */
    public function outerJoin(string $joinTable)
    {
        return $this->setJoinTable($joinTable, Join::OUTER_JOIN);
    }

    /**
     * Edit a JOIN table from Join list to build ON query
     */
    public function on($column1, $column2)
    {
        $lastJoin = $this->builder->lastJoin();
        if ($lastJoin instanceof Join) {
            $lastJoin->addColumn($column1, $column2);
        }
        return $this;
    }

    /**
     * Edit a JOIN table from Join list to build USING query
     */
    public function using($columns)
    {
        if (!is_array($columns)) {
            $columns = [$columns];
        }
        foreach ($columns as $column) {
            $lastJoin = $this->builder->lastJoin();
            if ($lastJoin instanceof Join) {
                $lastJoin->addColumn($column);
            }
        }
        return $this;
    }

}
