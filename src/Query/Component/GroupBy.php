<?php

namespace SparkLib\SparkQuery\Query\Component;

use SparkLib\SparkQuery\Structure\Column;

trait GroupBy
{

    /**
     * GROUP BY query manipulation
     */
    public function groupBy($columns)
    {
        $columnObjects = [];
        if (is_array($columns) && count($columns) > 1) {
            foreach ($columns as $column) {
                $columnObjects[] = Column::create($column);
            }
        } else {
            $columnObjects[] = Column::create($columns);
        }
        foreach ($columnObjects as $column) {
            $this->builder->addGroup($column);
        }
        return $this;
    }

}
