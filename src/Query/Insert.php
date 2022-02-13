<?php

namespace SparkLib\SparkQuery\Query;

use SparkLib\SparkQuery\Query\BaseQuery;
use SparkLib\SparkQuery\Query\Manipulation\LimitOffset;
use SparkLib\SparkQuery\Builder\BaseBuilder;
use SparkLib\SparkQuery\Builder\InsertBuilder;
use SparkLib\SparkQuery\Structure\Table;
use SparkLib\SparkQuery\Structure\Value;

class Insert extends BaseQuery
{

    /**
     * Constructor. Set builder type to insert
     */
    public function __construct($builder = null, $translator = 0, $bindingOption = 0, $statement = null)
    {
        $this->builder = $builder instanceof InsertBuilder ? $builder : new InsertBuilder;
        $this->builder->builderType(BaseBuilder::INSERT);
        $this->translator = $translator;
        $this->bindingOption = $bindingOption;
        $this->statement = $statement;
    }

    /**
     * INSERT INTO query
     * @param string $table
     * @return this
     */
    public function insert($table)
    {
        if ($table) {
            $tableObject = Table::create($table);
            $this->builder->setTable($tableObject);
        } else {
            throw new \Exception('Table name is not defined');
        }
        return $this;
    }

    /**
     * INSERT INTO SELECT query
     * @param string $table
     * @return this
     */
    public function insertCopy($table)
    {
        $this->builder->builderType(BaseBuilder::INSERT_COPY);
        return $this->insert($table);
    }

    /**
     * Add a value object to list of Column in builder object
     * @param array values
     * @return this
     */
    public function values(array $values)
    {
        $valueObject = Value::create($values);
        $this->builder->addValue($valueObject);
        return $this;
    }

    /**
     * Add multiple value objects to list of Column in builder object
     * @param array multiValues
     * @return this
     */
    public function multiValues(array $multiValues)
    {
        foreach ($multiValues as $values) {
            $valueObject = Value::create($values);
            $this->builder->addValue($valueObject);
        }
        return $this;
    }

    /**
     * Starting LIMIT and OFFSET query manipulation
     */
    private function limitOffsetManipulation()
    {
        return new LimitOffset($this->builder, Table::$table, $this->options, $this->statement);
    }

    /** LIMIT query manipulation method */
    public function limit($limit, $offset = null)
    {
        return $this->limitOffsetManipulation()->limit($limit, $offset);
    }

    /** OFFSET query manipulation method */
    public function offset($offset)
    {
        return $this->limitOffsetManipulation()->offset($offset);
    }

}