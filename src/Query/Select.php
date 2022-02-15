<?php

namespace SparkLib\SparkQuery\Query;

use SparkLib\SparkQuery\Query\BaseQuery;
use SparkLib\SparkQuery\Query\Component\Where;
use SparkLib\SparkQuery\Query\Component\GroupBy;
use SparkLib\SparkQuery\Query\Component\Having;
use SparkLib\SparkQuery\Query\Component\OrderBy;
use SparkLib\SparkQuery\Query\Component\LimitOffset;
use SparkLib\SparkQuery\Query\Component\JoinTable;
use SparkLib\SparkQuery\Builder\BaseBuilder;
use SparkLib\SparkQuery\Builder\SelectBuilder;
use SparkLib\SparkQuery\Structure\Table;
use SparkLib\SparkQuery\Structure\Column;
use SparkLib\SparkQuery\Structure\Expression;

/**
 * SELECT query manipulation class.
 */
class Select extends BaseQuery
{

    /**
     * Register methods from traits
     */
    use Where, Having, GroupBy, OrderBy, LimitOffset, JoinTable;

    /**
     * Constructor. Set builder type to select
     */
    public function __construct($translator = 0, $bindingOption = 0, $statement = null)
    {
        $this->builder = new SelectBuilder();
        $this->builder->builderType(BaseBuilder::SELECT);
        $this->translator = $translator;
        $this->bindingOption = $bindingOption;
        $this->statement = $statement;
    }

    /**
     * SELECT query table input
     */
    public function select($table)
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
     * SELECT DISTINC query table input
     */
    public function selectDistinct($table)
    {
        $this->builder->builderType(BaseBuilder::SELECT_DISTINCT);
        return $this->select($table);
    }

    /**
     * Add a column object to list of Column in builder object.
     * Takes a column name string or a dictionary with keys as column alias.
     */
    public function column($column)
    {
        $columnObject = Column::create($column);
        $this->builder->addColumn($columnObject);
        return $this;
    }

    /**
     * Add multiple column objects to list of Column in builder object.
     * Takes a list containing column name or a dictionary with keys as column alias.
     */
    public function columns(array $columns)
    {
        foreach ($columns as $alias => $column) {
            $columnObject = Column::create([$alias => $column]);
            $this->builder->addColumn($columnObject);
        }
        return $this;
    }

    /**
     * Add an expression object to list of Column in builder object.
     * Takes expression string, expression alias, and list of parameters.
     */
    public function columnExpression(string $expression, string $alias = '', array $params = [])
    {
        $expressionObject = Expression::create($expression, $alias, $params);
        $this->builder->addColumn($expressionObject);
        return $this;
    }

}
