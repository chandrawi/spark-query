<?php

namespace SparkLib\SparkQuery\Structure;

use SparkLib\SparkQuery\Structure\Table;

/**
 * Object for storing limit and offset of query operation. Used in LIMIT and OFFSET query
 */
class Value
{

    /**
     * Table name or table alias of values
     */
    private $table;

    /**
     * Array of column name of values
     */
    private $columns;

    /**
     * Array of values
     */
    private $values;

    /**
     * Constructor. Set columns array and values array
     */
    public function __construct(string $table, array $columns, array $values)
    {
        $this->table = $table;
        $this->columns = [];
        $this->values = [];
        $lenCol = count($columns);
        $lenVal = count($values);
        $len = $lenCol < $lenVal ? $lenCol : $lenVal;
        for ($i = 0; $i < $len; $i++) {
            $this->columns[] = $columns[$i];
            $this->values[] = $values[$i];
        }
    }

    /** Get table name of values */
    public function table()
    {
        return $this->table;
    }

    /** Get column name of values */
    public function columns()
    {
        return $this->columns;
    }

    /** Get values */
    public function values()
    {
        return $this->values;
    }

    /**
     * Create Value object from ascossiative array with key as column or sequential array of array
     */
    public static function create(array $inputValue): Value
    {
        $columns = [];
        $values = [];
        $len = count($inputValue);
        $lenRec = count($inputValue, 1);
        if ($len == $lenRec) {
            $columns = array_keys($inputValue);
            $values = array_values($inputValue);
        } elseif ($len + $len == $lenRec) {
            if ($len == 2) {
                list($columns, $values) = $inputValue;
            } else {
                list($columns, $values) = self::parsePair($inputValue);
            }
        }
        return new Value(Table::$table, $columns, $values);
    }

    /**
     * Parsing column and value pair from input array
     */
    private static function parsePair(array $pairs): array
    {
        $columns = [];
        $values = [];
        foreach ($pairs as $pair) {
            if (isset($pair[0]) && isset($pair[1])) {
                $columns[] = $pair[0];
                $values[] = $pair[1];
            } else {
                return [[], []];
            }
        }
        return [$columns, $values];
    }

}
