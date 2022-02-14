<?php

namespace SparkLib\SparkQuery\Interfaces;

use SparkLib\SparkQuery\Structure\Column;

interface IGroupBy
{

    /**
     * Get array of Column group object
     * @return array of Order object
     */
    public function getGroup(): array;

    /**
     * Count number of Column group object already added in builder object
     * @return int
     */
    public function countGroup(): int;

    /**
     * Add Column group object to GroupBy property of builder object
     * @param Column $group
     */
    public function addGroup(Column $group);

}
