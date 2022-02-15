<?php

namespace SparkLib\SparkQuery\Builder\Component;

use SparkLib\SparkQuery\Structure\Limit;

/**
 * Builder component for LIMIT and OFFSET query
 */
trait LimitBuilder
{

    /**
     * Limit structure object created by Limit manipulating class
     */
    private $limit = null;

    /**
     * Get limit and offset number
     */
    public function getLimit()
    {
        return $this->limit;
    }

    /**
     * Check limit or offset defined
     */
    public function hasLimit(): bool
    {
        return ($this->limit instanceof Limit);
    }

    /**
     * Set limit and offset number
     */
    public function setLimit(Limit $limit)
    {
        if (empty($this->limit)) {
            $this->limit = $limit;
        }
    }

}
