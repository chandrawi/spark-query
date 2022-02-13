<?php

namespace SparkLib\SparkQuery\Query\Manipulation;

use SparkLib\SparkQuery\Query\BaseQuery;
use SparkLib\SparkQuery\Interfaces\IGroupBy;
use SparkLib\SparkQuery\Structure\Column;

class GroupBy extends BaseQuery
{

    /**
     * Constructor.
     * Set the builder object
     */
    public function __construct($builderObject, $translator = 0, $bindingOption = 0, $statement = null)
    {
        if ($builderObject instanceof IGroupBy) {
            $this->builder = $builderObject;
            $this->translator = $translator;
            $this->bindingOption = $bindingOption;
            $this->statement = $statement;
        } else {
            throw new \Exception('Builder object not support GroupBy manipulation');
        }
    }

    /**
     * Call function for non-exist method calling.
     * Used for invoking next manipulation method in different class
     */
    public function __call($function, $arguments)
    {
        return $this->callQuery($function, $arguments);
    }

    /**
     * GROUP BY query manipulation
     */
    public function groupBy($column)
    {
        $columnObject = Column::create($column);
        $this->builder->addGroup($columnObject);
        return $this;
    }

    /**
     * GROUP BY query manipulation with multiple inputs
     */
    public function groupsBy(array $columns)
    {
        foreach ($columns as $column) {
            $this->groupBy($column);
        }
        return $this;
    }

}