<?php

namespace SparkLib\SparkQuery\Query\Manipulation;

use SparkLib\SparkQuery\Query\BaseQuery;
use SparkLib\SparkQuery\Interfaces\ILimit;
use SparkLib\SparkQuery\Structure\Limit;

class LimitOffset extends BaseQuery
{

    /**
     * Constructor.
     * Set the builder object
     */
    public function __construct($builderObject, $translator = 0, $bindingOption = 0, $statement = null)
    {
        if ($builderObject instanceof ILimit) {
            $this->builder = $builderObject;
            $this->translator = $translator;
            $this->bindingOption = $bindingOption;
            $this->statement = $statement;
        } else {
            throw new \Exception('Builder object not support LimitOffset manipulation');
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
     * LIMIT query manipulation
     */
    public function limit($limit, $offset)
    {
        $limitObject = Limit::create($limit, $offset);
        $this->builder->setLimit($limitObject);
        return $this;
    }

    /**
     * OFFSET query manipulation
     */
    public function offset($offset)
    {
        return $this->limit(Limit::NOT_SET, $offset);
    }

}