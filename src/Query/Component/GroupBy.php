<?php

namespace SparkLib\SparkQuery\Query\Component;

use SparkLib\SparkQuery\Structure\Column;
use SparkLib\SparkQuery\Interfaces\IGroupBy;

/**
 * GROUP BY manipulation component.
 */
trait GroupBy
{

    /**
     * GROUP BY query manipulation
     */
    public function groupBy($columns)
    {
        $columnObjects = Column::createMulti($columns);
        foreach ($columnObjects as $column) {
            if ($this->builder instanceof IGroupBy) {
                $this->builder->addGroup($column);
            } else {
                throw new \Exception('Builder object does not support GROUP BY query');
            }
        }
        return $this;
    }

}
