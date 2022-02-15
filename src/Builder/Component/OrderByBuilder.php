<?php

namespace SparkLib\SparkQuery\Builder\Component;

use SparkLib\SparkQuery\Structure\Order;

/**
 * Builder component for ORDER BY query
 */
trait OrderByBuilder
{

    /**
     * Array of OrderBy structure object created by OrderBy manipulation class
     */
    private $orderBy = [];

    /**
     * Get query result order list
     */
    public function getOrder(): array
    {
        return $this->orderBy;
    }

    /**
     * Count query result order list
     */
    public function countOrder(): int
    {
        return count($this->orderBy);
    }

    /**
     * Add a query result order to order list
     */
    public function addOrder(Order $order)
    {
        $this->orderBy[] = $order;
    }

}
