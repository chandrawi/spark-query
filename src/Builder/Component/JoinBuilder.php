<?php

namespace SparkLib\SparkQuery\Builder\Component;

use SparkLib\SparkQuery\Structure\Join;

/**
 * Builder component for JOIN query
 */
trait JoinBuilder
{

    /**
     * Array of Join structure object created by JoinTable manipulation class
     */
    private $join = [];

    /**
     * Get list of join table
     */
    public function getJoin(): array
    {
        return $this->join;
    }

    /**
     * Get last join in where list
     */
    public function lastJoin()
    {
        $len = count($this->join);
        if ($len > 0) {
            return $this->join[$len-1];
        } else {
            return null;
        }
    }

    /**
     * Count list of join table
     */
    public function countJoin(): int
    {
        return count($this->join);
    }

    /**
     * Add a join to join list
     */
    public function addJoin(Join $join)
    {
        $this->join[] = $join;
    }

}
