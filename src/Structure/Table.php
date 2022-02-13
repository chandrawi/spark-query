<?php

namespace SparkLib\SparkQuery\Structure;

class Table
{

    /**
     * Table name or join table name for query builder process
     */
    public static $table;

    /**
     * Table name
     */
    private $name;

    /**
     * Table alias name
     */
    private $alias;

    /**
     * Constructor. Set table name and alias
     */
    public function __construct(string $name, string $alias = '')
    {
        $this->name = $name;
        $this->alias = $alias;
    }

    /** Get table name */
    public function name()
    {
        return $this->name;
    }

    /** Get table alias */
    public function alias()
    {
        return $this->alias;
    }

    /**
     * Create table object from string input or ascossiative array with key as alias
     */
    public static function create($table): Table
    {
        if (is_array($table)) {
            $alias = strval(array_keys($table)[0]);
            $tableObject = new Table(strval(array_values($table)[0]), $alias);
            self::$table = $alias;
        } else {
            $name = strval($table);
            $tableObject = new Table($name);
            self::$table = $name;
        }
        return $tableObject;
    }

}
