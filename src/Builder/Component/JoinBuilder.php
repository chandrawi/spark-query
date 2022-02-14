<?php

namespace SparkLib\SparkQuery\Builder\Component;

use SparkLib\SparkQuery\Structure\Join;

trait JoinBuilder
{

    /**
     * Array of Join structure object created by JoinTable manipulation class
     */
    private $join = [];

    /**
     * Interface IJoin required method
     */
    public function getJoin(): array
    {
        return $this->join;
    }

    /**
     * Interface IJoin required method
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
     * Interface IJoin required method
     */
    public function countJoin(): int
    {
        return count($this->join);
    }

    /**
     * Interface IJoin required method
     */
    public function addJoin(Join $join)
    {
        $this->join[] = $join;
    }

}
