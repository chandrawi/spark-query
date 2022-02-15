<?php

namespace SparkLib\SparkQuery\Builder\Component;

use SparkLib\SparkQuery\Structure\Clause;

/**
 * Builder component for HAVING clause query
 */
trait HavingBuilder
{

    /**
     * Array of Clause structure object created by Having manipulation class
     */
    private $having = [];

    /**
     * Get list of having clause
     */
    public function getHaving(): array
    {
        return $this->having;
    }

    /**
     * Get last having clause in having list
     */
    public function lastHaving()
    {
        $len = count($this->having);
        if ($len > 0) {
            return $this->having[$len-1];
        } else {
            return null;
        }
    }

    /**
     * Count list of having clause
     */
    public function countHaving(): int
    {
        return count($this->having);
    }

    /**
     * Add a having clause to having list
     */
    public function addHaving(Clause $having)
    {
        $this->having[] = $having;
    }

}
