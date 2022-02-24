<?php

namespace SparkLib\SparkQuery\Structure;

use SparkLib\SparkQuery\Structure\Table;

/**
 * Object for storing a column definition.
 */
class Column
{

    /**
     * Table name or table alias of column
     */
    private $table;

    /**
     * Column name
     */
    private $name;

    /**
     * Alias name of column
     */
    private $alias;

    /**
     * Aggregate function applied to column
     */
    private $function;

    /**
     * Constructor. Clear all properties
     */
    public function __construct(string $table, string $name, string $alias = '', string $function = '')
    {
        $this->table = $table;
        $this->name = $name;
        $this->alias = $alias;
        $this->function = $function;
    }

    /** Get table name or table alias of column */
    public function table()
    {
        return $this->table;
    }

    /** Get name of column */
    public function name()
    {
        return $this->name;
    }

    /** Get alias name of column */
    public function alias()
    {
        return $this->alias;
    }

    /** Get SQL aggregate function */
    public function function()
    {
        return $this->function;
    }

    /**
     * Create column object from string input or associative array with key as alias
     */
    public static function create($column): Column
    {
        $table = '';
        $name = '';
        $function = '';
        $alias = '';
        if (is_string($column)) {
            list($table, $name, $function) = self::parseString($column);
        } elseif (is_array($column)) {
            list($table, $name, $function, $alias) = self::parseArray($column);
        }
        return new Column($table, $name, $alias, $function);
    }

    /**
     * Create multiple Column objects
     */
    public static function createMulti($columns)
    {
        $columnObjects = [];
        if (is_string($columns)) {
            $columnObjects[] = self::create($columns);
        } elseif (is_array($columns)) {
            foreach ($columns as $col) {
                $columnObjects[] = self::create($col);
            }
        }
        return $columnObjects;
    }

    /**
     * Parsing string input column to table, column name, and aggregate function
     */
    private static function parseString(string $column): array
    {
        $function = '';
        if (substr($column, -1, 1) == ')' && false !== $pos = strpos($column, '(')) {
            $function = substr($column, 0, $pos);
            $column = substr($column, $pos+1, strlen($column)-$pos-2);
        }
        $exploded = explode('.', $column, 2);
        if (count($exploded) == 2) {
            $table = trim($exploded[0], "\"\`\'\r\n ");
            $name = trim($exploded[1], "\"\`\'\r\n ");
        } else {
            $table = Table::$table;
            $name = trim($column, "\"\`\'\r\n ");
        }
        return [$table, $name, $function];
    }

    /**
     * Parsing array input column to table, column name, aggregate function, and alias name
     */
    private static function parseArray(array $column): array
    {
        $alias = '';
        $keys = array_keys($column);
        if (count($keys) == 1) {
            is_int($keys[0]) ?: $alias = $keys[0];
            $column = $column[$keys[0]];
        }
        $table = isset($column['table']) ? $column['table'] : Table::$table;
        $name = isset($column['column']) ? $column['column'] : '';
        $function = isset($column['function']) ? $column['function'] : '';
        if (is_string($column)) {
            list($table, $name, $function) = self::parseString($column);
        }
        return [$table, $name, $function, $alias];
    }

}
