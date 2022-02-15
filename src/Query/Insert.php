<?php

namespace SparkLib\SparkQuery\Query;

use SparkLib\SparkQuery\Query\BaseQuery;
use SparkLib\SparkQuery\Query\Component\LimitOffset;
use SparkLib\SparkQuery\Builder\BaseBuilder;
use SparkLib\SparkQuery\Builder\InsertBuilder;
use SparkLib\SparkQuery\Structure\Table;
use SparkLib\SparkQuery\Structure\Value;

/**
 * INSERT query manipulation class.
 */
class Insert extends BaseQuery
{

    /**
     * Register methods from traits
     */
    use LimitOffset;

    /**
     * Constructor. Set builder type to insert
     */
    public function __construct($translator = 0, $bindingOption = 0, $statement = null)
    {
        $this->builder = new InsertBuilder();
        $this->builder->builderType(BaseBuilder::INSERT);
        $this->translator = $translator;
        $this->bindingOption = $bindingOption;
        $this->statement = $statement;
    }

    /**
     * INSERT INTO query query table input
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
     * INSERT INTO SELECT query table input
     */
    public function insertCopy($table)
    {
        $this->builder->builderType(BaseBuilder::INSERT_COPY);
        return $this->insert($table);
    }

    /**
     * Add value and column pair list in builder object.
     * Takes a dictionary with keys as column or list of two list with first item as column.
     */
    public function values(array $values)
    {
        $valueObject = Value::create($values);
        $this->builder->addValue($valueObject);
        return $this;
    }

    /**
     * Add multiple value and column pair list in builder object.
     * Takes list of dictionary with keys as column.
     */
    public function multiValues(array $multiValues)
    {
        foreach ($multiValues as $values) {
            $valueObject = Value::create($values);
            $this->builder->addValue($valueObject);
        }
        return $this;
    }

}
