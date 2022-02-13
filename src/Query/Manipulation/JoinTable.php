<?php

namespace SparkLib\SparkQuery\Query\Manipulation;

use SparkLib\SparkQuery\Query\BaseQuery;
use SparkLib\SparkQuery\Structure\Join;

class JoinTable extends BaseQuery
{

    /**
     * Constructor.
     * Set the builder object
     */
    public function __construct($builderObject, $translator = 0, $bindingOption = 0, $statement = null)
    {
        $this->builder = $builderObject;
        $this->translator = $translator;
        $this->bindingOption = $bindingOption;
        $this->statement = $statement;
    }

    /**
     * Call function for non-exist method calling.
     * Used for invoking next manipulation method in different class
     */
    public function __call($function, $arguments)
    {
        return $this->callQuery($function, $arguments);
    }

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
            $this->addJoinColumn($column);
        }
        return $this;
    }


}
