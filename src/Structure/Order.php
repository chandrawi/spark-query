<?php

namespace SparkLib\SparkQuery\Structure;

use SparkLib\SparkQuery\Structure\Column;

class Order
{

    /**
     * Column object
     */
    private $column;

    /**
     * Order type
     */
    private $orderType;

    /** Order type */
    public const ORDER_NONE = 0;
    /** Order type */
    public const ORDER_ASC = 1;
    /** Order type */
    public const ORDER_DESC = 2;

    /**
     * Constructor. Order column and order type
     */
    public function __construct(Column $column, int $orderType)
    {
        $this->column = $column;
        $this->orderType = ($orderType >= 1 && $orderType <=2) ? $orderType : self::ORDER_NONE;
    }

    /** Get order column */
    public function column(): Column
    {
        return $this->column;
    }

    /** Get order type */
    public function orderType(): int
    {
        return $this->orderType;
    }

    /**
     * Create list of Order object from column inputs and order type for ORDER BY query
     */
    public static function create($column, $orderType): Order
    {
        $columnObject = Column::create($column);
        $validType = self::getType($orderType);
        return new Order($columnObject, $validType);
    }

    /**
     * Get valid order type from input order type
     */
    private static function getType($orderType): int
    {
        if (is_int($orderType)) {
            $validType = $orderType;
        } else {
            switch ($orderType) {
                case 'ascending':
                case 'asc':
                case 'ASCENDING':
                case 'ASC':
                    $validType = Order::ORDER_ASC;
                break;
                case 'descending':
                case 'desc':
                case 'DESCENDING':
                case 'DESC':
                    $validType = Order::ORDER_DESC;
                break;
                default:
                    $validType = Order::ORDER_NONE;
            }
        }
        return $validType;
    }

}
