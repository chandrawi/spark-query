<?php

namespace SparkLib\SparkQuery\Query;

use SparkLib\SparkQuery\Query\BaseQuery;
use SparkLib\SparkQuery\Query\Component\Where;
use SparkLib\SparkQuery\Query\Component\LimitOffset;
use SparkLib\SparkQuery\Query\Component\JoinTable;
use SparkLib\SparkQuery\Builder\BaseBuilder;
use SparkLib\SparkQuery\Builder\UpdateBuilder;
use SparkLib\SparkQuery\Structure\Table;
use SparkLib\SparkQuery\Structure\Value;

class Update extends BaseQuery
{

    /**
     * Register methods from traits
     */
    use Where, LimitOffset, JoinTable;

    /**
     * Constructor. Set builder type to update
     */
    public function __construct($translator = 0, $bindingOption = 0, $statement = null)
    {
        $this->builder = new UpdateBuilder();
        $this->builder->builderType(BaseBuilder::UPDATE);
        $this->translator = $translator;
        $this->bindingOption = $bindingOption;
        $this->statement = $statement;
    }

    /**
     * UPDATE query
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
     */
    public function set(array $values)
    {
        $valueObject = Value::create($values);
        $this->builder->addValue($valueObject);
        return $this;
    }

}
