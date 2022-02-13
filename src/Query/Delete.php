<?php

namespace SparkLib\SparkQuery\Query;

use SparkLib\SparkQuery\Query\BaseQuery;
use SparkLib\SparkQuery\Query\Manipulation\Where;
use SparkLib\SparkQuery\Query\Manipulation\LimitOffset;
use SparkLib\SparkQuery\Builder\BaseBuilder;
use SparkLib\SparkQuery\Builder\DeleteBuilder;
use SparkLib\SparkQuery\Structure\Table;

class Delete extends BaseQuery
{

    /**
     * Constructor. Set builder type to insert
     */
    public function __construct($builder = null, $translator = 0, $bindingOption = 0, $statement = null)
    {
        $this->builder = $builder instanceof DeleteBuilder ? $builder : new DeleteBuilder;
        $this->builder->builderType(BaseBuilder::DELETE);
        $this->translator = $translator;
        $this->bindingOption = $bindingOption;
        $this->statement = $statement;
    }

    /**
     * UPDATE query
     * @param string $table
     * @return this
     */
    public function delete($table)
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

}