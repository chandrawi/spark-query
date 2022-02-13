<?php

namespace SparkLib\SparkQuery\Query;

use SparkLib\SparkQuery\Query\BaseQuery;
use SparkLib\SparkQuery\Query\Manipulation\Where;
use SparkLib\SparkQuery\Query\Manipulation\LimitOffset;
use SparkLib\SparkQuery\Query\Manipulation\JoinTable;
use SparkLib\SparkQuery\Builder\BaseBuilder;
use SparkLib\SparkQuery\Builder\UpdateBuilder;
use SparkLib\SparkQuery\Structure\Table;
use SparkLib\SparkQuery\Structure\Value;

class Update extends BaseQuery
{

    /**
     * Constructor. Set builder type to insert
     */
    public function __construct($builder = null, $translator = 0, $bindingOption = 0, $statement = null)
    {
        $this->builder = $builder instanceof UpdateBuilder ? $builder : new UpdateBuilder;
        $this->builder->builderType(BaseBuilder::UPDATE);
        $this->translator = $translator;
        $this->bindingOption = $bindingOption;
        $this->statement = $statement;
    }

    /**
     * UPDATE query
     * @param string $table
     * @return this
     */
    public function update($table)
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
     * starting WHERE query manipulation 
     */
    private function whereManipulation()
    {
        return new Where($this->builder, $this->translator, $this->bindingOption, $this->statement);
    }

    /** WHERE query manipulation method */
    public function beginWhere()
    {
        return $this->whereManipulation()->beginWhere();
    }

    /** WHERE query manipulation method */
    public function where($column, string $operator, $values = null)
    {
        return $this->whereManipulation()->where($column, $operator, $values);
    }

    /** WHERE query manipulation method */
    public function orWhere($column, string $operator, $values = null)
    {
        return $this->whereManipulation()->orWhere($column, $operator, $values);
    }

    /** WHERE query manipulation method */
    public function whereExpression(string $expression, string $operator, $values = null, array $params = [])
    {
        return $this->whereManipulation()->whereExpression($expression, $operator, $values, $params);
    }

    /** WHERE query manipulation method */
    public function orWhereExpression(string $expression, string $operator, $values = null, array $params = [])
    {
        return $this->whereManipulation()->whereExpression($expression, $operator, $values, $params);
    }

    /**
     * Starting LIMIT and OFFSET query manipulation
     */
    private function limitOffsetManipulation()
    {
        return new LimitOffset($this->builder, $this->translator, $this->bindingOption, $this->statement);
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

    /**
     * Starting JOIN query manipulation
     */
    private function joinTableManipulation()
    {
        return new JoinTable($this->builder, $this->translator, $this->bindingOption, $this->statement);
    }

    /** JOIN query manipulation method */
    public function join($joinTable, $jointType)
    {
        return $this->joinTableManipulation()->join($joinTable, $jointType);
    }

    /** INNER JOIN query manipulation method */
    public function innerJoin($joinTable)
    {
        return $this->joinTableManipulation()->innerJoin($joinTable);
    }

    /** LEFT JOIN query manipulation method */
    public function leftJoin($joinTable)
    {
        return $this->joinTableManipulation()->leftJoin($joinTable);
    }

    /** RIGHT JOIN query manipulation method */
    public function rightJoin($joinTable)
    {
        return $this->joinTableManipulation()->rightJoin($joinTable);
    }

    /** OUTER JOIN query manipulation method */
    public function outerJoin($joinTable)
    {
        return $this->joinTableManipulation()->outerJoin($joinTable);
    }

}