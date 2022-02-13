<?php

namespace SparkLib\SparkQuery\Query\Component;

use SparkLib\SparkQuery\Structure\Limit;

trait LimitOffset
{

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
