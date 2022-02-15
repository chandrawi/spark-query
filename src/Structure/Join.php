<?php

namespace SparkLib\SparkQuery\Structure;

use SparkLib\SparkQuery\Structure\Table;
use SparkLib\SparkQuery\Structure\Column;

/**
 * Object for storing join table query definition. Used in INNER JOIN, LEFT JOIN, RIGHT JOIN, or OUTER JOIN query
 */
class Join
{

    /**
     * Base table name for query builder process
     */
    public static $table = '';

    /**
     * Type of join of the table
     */
    private $joinType;

    /** Join type options */
    public const NO_JOIN = 0;
    /** Join type options */
    public const INNER_JOIN = 1;
    /** Join type options */
    public const LEFT_JOIN = 2;
    /** Join type options */
    public const RIGHT_JOIN = 3;
    /** Join type options */
    public const OUTER_JOIN = 4;

    /**
     * Base table name or alias for join query
     */
    private $baseTable;

    /**
     * Join table name
     */
    private $joinTable;

    /**
     * Join table alias name
     */
    private $joinAlias;

    /**
     * Columns of base table
     */
    private $baseColumns;

    /**
     * Columns of the table to be joined with ON keyword
     */
    private $joinColumns;

    /**
     * Columns list of table to be joined with USING keyword
     */
    private $usingColumns;

    /**
     * Constructor. Set join type, base table, and join table
     */
    public function __construct(int $joinType, string $baseTable, string $joinTable, string $joinAlias = '')
    {
        $this->joinType = $joinType;
        $this->baseTable = $baseTable;
        $this->joinTable = $joinTable;
        $this->joinAlias = $joinAlias;
        $this->baseColumns = [];
        $this->joinColumns = [];
        $this->usingColumns = [];
    }

    /** Get join type */
    public function joinType(): int
    {
        return $this->joinType;
    }

    /** Get base table name */
    public function baseTable(): string
    {
        return $this->baseTable;
    }

    /** Get join table name */
    public function joinTable(): string
    {
        return $this->joinTable;
    }

    /** Get join table alias name */
    public function joinAlias(): string
    {
        return $this->joinAlias;
    }

    /** Get base column objects list */
    public function baseColumns(): array
    {
        return $this->baseColumns;
    }

    /** Get join column objects list */
    public function joinColumns(): array
    {
        return $this->joinColumns;
    }

    /** Get using column objects list */
    public function usingColumns(): array
    {
        return $this->usingColumns;
    }

    /**
     * Create join table object from joint type and input table
     */
    public static function create($joinTable, $joinType): Join
    {
        self::$table = Table::$table;
        $validType = self::getType($joinType);
        if (is_array($joinTable)) {
            $joinAlias = strval(array_keys($joinTable)[0]);
            $tableObject = new Join($validType, Table::$table, strval(array_values($joinTable)[0]), $joinAlias);
            Table::$table = $joinAlias;
        } else {
            $joinTable = strval($joinTable);
            $tableObject = new Join($validType, Table::$table, $joinTable);
            Table::$table = $joinTable;
        }
        return $tableObject;
    }

    /**
     * Get a valid join type option from input join type
     */
    private static function getType($joinType): int
    {
        if (is_int($joinType) && $joinType > 0 && $joinType <= 4) {
            $validType = $joinType;
        } else {
            switch ($joinType) {
                case 'INNER':
                case 'INNER JOIN':
                    $validType = Join::INNER_JOIN;
                break;
                case 'LEFT':
                case 'LEFT JOIN':
                    $validType = Join::LEFT_JOIN;
                break;
                case 'RIGHT':
                case 'RIGHT JOIN':
                    $validType = Join::RIGHT_JOIN;
                break;
                case 'OUTER':
                case 'OUTER JOIN':
                    $validType = Join::OUTER_JOIN;
                break;
                default:
                    $validType = Join::NO_JOIN;
            }
        }
        return $validType;
    }

    /**
     * Add columns object property to a join table object
     */
    public function addColumn($column1, $column2 = null)
    {
        $table = Table::$table;
        Table::$table = self::$table;
        $columnObject1 = Column::create($column1);
        Table::$table = $table;
        if ($column2 === null) {
            $this->usingColumns[] = $columnObject1;
        } else {
            $columnObject2 = Column::create($column2);
            $this->baseColumns[] = $columnObject1;
            $this->joinColumns[] = $columnObject2;
        }
    }

}
