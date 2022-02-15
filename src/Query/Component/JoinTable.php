<?php

namespace SparkLib\SparkQuery\Query\Component;

use SparkLib\SparkQuery\Structure\Join;
use SparkLib\SparkQuery\Interfaces\IJoin;

/**
 * Join table manipulation component.
 * Used for INNER JOIN, LEFT JOIN, RIGHT JOIN, OUTER JOIN query.
 */
trait JoinTable
{

    /**
     * Add Join object to join property of Builder object
     */
    private function setJoinTable($joinTable, int $joinType)
    {
        $joinObject = Join::create($joinTable, $joinType);
        if ($this->builder instanceof IJoin) {
            $this->builder->addJoin($joinObject);
        } else {
            throw new \Exception('Builder object does not support JOIN query');
        }
        return $this;
    }

    /** INNER JOIN query manipulation method. Takes join table name input */
    public function innerJoin($joinTable)
    {
        return $this->setJoinTable($joinTable, Join::INNER_JOIN);
    }

    /** LEFT JOIN query manipulation method. Takes join table name input */
    public function leftJoin($joinTable)
    {
        return $this->setJoinTable($joinTable, Join::LEFT_JOIN);
    }

    /** RIGHT JOIN query manipulation method. Takes join table name input */
    public function rightJoin(string $joinTable)
    {
        return $this->setJoinTable($joinTable, Join::RIGHT_JOIN);
    }

    /** OUTER JOIN query manipulation method. Takes join table name input */
    public function outerJoin(string $joinTable)
    {
        return $this->setJoinTable($joinTable, Join::OUTER_JOIN);
    }

    /**
     * Add join columns and build ON query
     */
    public function on($column1, $column2)
    {
        if ($this->builder instanceof IJoin) {
            $lastJoin = $this->builder->lastJoin();
            if ($lastJoin !== null) {
                $lastJoin->addColumn($column1, $column2);
            }
        }
        return $this;
    }

    /**
     * Add join columns and build USING query
     */
    public function using($columns)
    {
        if (!is_array($columns)) {
            $columns = [$columns];
        }
        if ($this->builder instanceof IJoin) {
            $lastJoin = $this->builder->lastJoin();
            if ($lastJoin !== null) {
                foreach ($columns as $column) {
                    $lastJoin->addColumn($column);
                }
            }
        }
        return $this;
    }

}
