<?php

namespace SparkLib\SparkQuery\Builder\Component;

use SparkLib\SparkQuery\Structure\Clause;

trait HavingBuilder
{

    /**
     * Array of Clause structure object created by Having manipulation class
     */
    private $having = [];

    /**
     * Interface Ihaving required method
     */
    public function getHaving(): array
    {
        return $this->having;
    }

    /**
     * Interface Ihaving required method
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
     * Interface Ihaving required method
     */
    public function countHaving(): int
    {
        return count($this->having);
    }

    /**
     * Interface Ihaving required method
     */
    public function addHaving(Clause $having)
    {
        $this->having[] = $having;
    }

}
