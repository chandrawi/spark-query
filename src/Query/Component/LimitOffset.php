<?php

namespace SparkLib\SparkQuery\Query\Component;

use SparkLib\SparkQuery\Structure\Limit;
use SparkLib\SparkQuery\Interfaces\ILimit;

trait LimitOffset
{

    /**
     * LIMIT query manipulation
     */
    public function limit($limit, $offset = Limit::NOT_SET)
    {
        $limitObject = Limit::create($limit, $offset);
        if ($this->builder instanceof ILimit) {
            $this->builder->setLimit($limitObject);
        } else {
            throw new \Exception('Builder object does not support LIMIT and OFFSET query');
        }
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
