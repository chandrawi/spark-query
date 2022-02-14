<?php

namespace SparkLib\SparkQuery\Builder\Component;

use SparkLib\SparkQuery\Structure\Order;

trait OrderByBuilder
{

    /**
     * Array of OrderBy structure object created by OrderBy manipulation class
     */
    private $orderBy = [];

    /**
     * Interface IOrderBy required method
     */
    public function getOrder(): array
    {
        return $this->orderBy;
    }

    /**
     * Interface IOrderBy required method
     */
    public function countOrder(): int
    {
        return count($this->orderBy);
    }

    /**
     * Interface IOrderBy required method
     */
    public function addOrder(Order $order)
    {
        $this->orderBy[] = $order;
    }

}
