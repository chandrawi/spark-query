<?php

namespace SparkLib\SparkQuery\Query\Component;

use SparkLib\SparkQuery\Structure\Order;
use SparkLib\SparkQuery\Interfaces\IOrderBy;

trait OrderBy
{

    /**
     * ORDER BY query manipulation
     */
    public function orderBy($columns, $orderType)
    {
        $orderObjects = [];
        if (is_array($columns) && count($columns) > 1) {
            foreach ($columns as $column) {
                $orderObjects[] = Order::create($column, $orderType);
            }
        } else {
            $orderObjects[] = Order::create($columns, $orderType);
        }
        foreach ($orderObjects as $order) {
            if ($this->builder instanceof IOrderBy) {
                $this->builder->addOrder($order);
            } else {
                throw new \Exception('Builder object does not support ORDER BY query');
            }
        }
        return $this;
    }

    /**
     * ORDER BY query manipulation using ASC order
     */
    public function orderByAsc($columns)
    {
        return $this->orderBy($columns, Order::ORDER_ASC);
    }

    /**
     * ORDER BY query manipulation using DESC order
     */
    public function orderByDesc($columns)
    {
        return $this->orderBy($columns, Order::ORDER_DESC);
    }

}
