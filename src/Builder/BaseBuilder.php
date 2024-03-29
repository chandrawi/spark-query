<?php

namespace SparkLib\SparkQuery\Builder;

use SparkLib\SparkQuery\Structure\Table;
use SparkLib\SparkQuery\Structure\Column;
use SparkLib\SparkQuery\Structure\Value;
use SparkLib\SparkQuery\Structure\Expression;
use SparkLib\SparkQuery\Interfaces\IBuilder;

/**
 * Base of builder object.
 * Basic template for building a query
 */
class BaseBuilder implements IBuilder
{

    /**
     * Builder object type
     */
    protected $builderType = 0;

    /** Builder object type options */
    public const SELECT = 1;
    /** Builder object type options */
    public const INSERT = 2;
    /** Builder object type options */
    public const UPDATE = 3;
    /** Builder object type options */
    public const DELETE = 4;
    /** Builder object type options */
    public const SELECT_DISTINCT = 5;
    /** Builder object type options */
    public const SELECT_UNION = 6;
    /** Builder object type options */
    public const SELECT_INTERSECT = 7;
    /** Builder object type options */
    public const SELECT_MINUS = 8;
    /** Builder object type options */
    public const INSERT_COPY = 9;

    /**
     * Get or set builder object type
     */
    public function builderType(int $type = 0): int
    {
        if ($type > 0 && $type <= 9) {
            $this->builderType = $type;
        }
        return $this->builderType;
    }

     /**
     * Table structure object
     */
    protected $table = null;

    /**
     * List of Column structure object
     */
    protected $columns = [];

    /**
     * List of Value structure object
     */
    protected $values = [];

    /**
     * Set table for a builder
     */
    public function setTable(Table $table)
    {
        if (empty($this->table)) {
            $this->table = $table;
        }
    }

    /**
     * Get table of a builder
     */
    public function getTable(): Table
    {
        return $this->table;
    }

    /**
     * Add a column or column expression to Column list
     */
    public function addColumn($column)
    {
        if ($column instanceof Column || $column instanceof Expression) {
            $this->columns[] = $column;
        }
    }

    /**
     * Get list of columns
     */
    public function getColumns(): array
    {
        return $this->columns;
    }

    /**
     * Count column list
     */
    public function countColumns(): int
    {
        return count($this->columns);
    }

    /**
     * Add a value to Value list
     */
    public function addValue(Value $value)
    {
        $this->values[] = $value;
    }

    /**
     * Get Value list
     */
    public function getValues(): array
    {
        return $this->values;
    }

    /**
     * Count Value list
     */
    public function countValues(): int
    {
        return count($this->values);
    }

}
