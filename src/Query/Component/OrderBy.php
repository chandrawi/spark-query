<?php

namespace SparkLib\SparkQuery\Query\Component;

use SparkLib\SparkQuery\Structure\Column;
use SparkLib\SparkQuery\Structure\Order;
use SparkLib\SparkQuery\Interfaces\IOrderBy;

/**
 * ORDER BY manipulation component.
 */
trait OrderBy
{

    /**
     * ORDER BY query manipulation
     */
    public function orderBy($columns, $orderType)
    {
        $columnObjects = Column::createMulti($columns);
        foreach ($columnObjects as $columnObject) {
            $orderObject = Order::create($columnObject, $orderType);
            if ($this->builder instanceof IOrderBy) {
                $this->builder->addOrder($orderObject);
            } else {
                throw new \Exception('Builder object does not support ORDER BY query');
            }
        }
        return $this;
    }

    /**
     * ORDER BY query with ASC order
     */
    public function orderByAsc($columns)
    {
        return $this->orderBy($columns, Order::ORDER_ASC);
    }

    /**
     * ORDER BY query with DESC order
     */
    public function orderByDesc($columns)
    {
        return $this->orderBy($columns, Order::ORDER_DESC);
    }

}
