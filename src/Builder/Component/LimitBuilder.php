<?php

namespace SparkLib\SparkQuery\Builder\Component;

use SparkLib\SparkQuery\Structure\Limit;

trait LimitBuilder
{

    /**
     * Limit structure object created by Limit manipulating class
     */
    private $limit = null;

    /**
     * Interface ILimit required method
     */
    public function getLimit()
    {
        return $this->limit;
    }

    /**
     * Interface ILimit required method
     */
    public function hasLimit(): bool
    {
        return ($this->limit instanceof Limit);
    }

    /**
     * Interface ILimit required method
     */
    public function setLimit(Limit $limit)
    {
        if (empty($this->limit)) {
            $this->limit = $limit;
        }
    }

}
