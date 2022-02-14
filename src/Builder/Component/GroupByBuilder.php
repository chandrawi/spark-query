<?php

namespace SparkLib\SparkQuery\Builder\Component;

use SparkLib\SparkQuery\Structure\Column;

trait GroupByBuilder
{

    /**
     * Array of Column structure object created by GroupBy manipulation class
     */
    protected $groupBy = [];

    /**
     * Interface IGroupBy required method
     */
    public function getGroup(): array
    {
        return $this->groupBy;
    }

    /**
     * Interface IGroupBy required method
     */
    public function countGroup(): int
    {
        return count($this->groupBy);
    }

    /**
     * Interface IGroupBy required method
     */
    public function addGroup(Column $group)
    {
        $this->groupBy[] = $group;
    }

}
