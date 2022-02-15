<?php

namespace SparkLib\SparkQuery\Builder\Component;

use SparkLib\SparkQuery\Structure\Column;

/**
 * Builder component for GROUP BY query
 */
trait GroupByBuilder
{

    /**
     * Array of Column structure object created by GroupBy manipulation class
     */
    protected $groupBy = [];

    /**
     * Get list of column group
     */
    public function getGroup(): array
    {
        return $this->groupBy;
    }

    /**
     * Count list of column group
     */
    public function countGroup(): int
    {
        return count($this->groupBy);
    }

    /**
     * Add a column to group list
     */
    public function addGroup(Column $group)
    {
        $this->groupBy[] = $group;
    }

}
