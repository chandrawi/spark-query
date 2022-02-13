<?php

namespace SparkLib\SparkQuery\Query\Manipulation;

use SparkLib\SparkQuery\Query\BaseQuery;
use SparkLib\SparkQuery\Interfaces\IOrderBy;
use SparkLib\SparkQuery\Structure\Column;
use SparkLib\SparkQuery\Structure\Order;

class OrderBy extends BaseQuery
{

    /**
     * Constructor.
     * Set the builder object
     */
    public function __construct($builderObject, $translator = 0, $bindingOption = 0, $statement = null)
    {
        if ($builderObject instanceof IOrderBy) {
            $this->builder = $builderObject;
            $this->translator = $translator;
            $this->bindingOption = $bindingOption;
            $this->statement = $statement;
        } else {
            throw new \Exception('Builder object not support OrderBy manipulation');
        }
    }

    /**
     * Call function for non-exist method calling.
     * Used for invoking next manipulation method in different class
     */
    public function __call($function, $arguments)
    {
        return $this->callQuery($function, $arguments);
    }

    /**
     * Creating Order object
     * @param Column $column
     * @param mixed $orderType
     * @return Order
     */
    private function createOrder($column, $orderType)
    {
        $orderObject = Order::create($column, $orderType);
        return $orderObject;
    }

    /**
     * ORDER BY query manipulation
     */
    public function orderBy($columns, $orderType)
    {
        $orderObjects = Order::create($columns, $orderType);
        foreach ($orderObjects as $order) {
            $this->builder->addOrder($order);
        }
        return $this;
    }

    /**
     * ORDER BY query manipulation using ASC order
     */
    public function orderAsc($columns)
    {
        return $this->orderBy($columns, Order::ORDER_ASC);
    }

    /**
     * ORDER BY query manipulation using DESC order
     */
    public function orderDesc($columns)
    {
        return $this->orderBy($columns, Order::ORDER_DESC);
    }

}
