<?php

namespace SparkLib\SparkQuery\Structure;

use SparkLib\SparkQuery\Structure\Column;
use SparkLib\SparkQuery\Structure\Expression;

/**
 * Object for storing a clause query structure. Used in WHERE and HAVING query.
 */
class Clause
{

    /**
     * Clause type for query builder process
     */
    public static $clauseType = self::NONE;

    /**
     * Stored nested conjunctive for query builder process
     */
    public static $nestedConjunctive = self::CONJUNCTIVE_NONE;

    /**
     * Stored nested level for query builder process
     */
    public static $nestedLevel = 0;

    /** Clause object type */
    public const NONE = 0;
    /** Clause object type */
    public const WHERE = 1;
    /** Clause object type */
    public const HAVING = 2;

    /**
     * Column object
     */
    private $column;

    /**
     * Clause operator
     */
    private $operator;

    /** Operator type */
    public const OPERATOR_DEFAULT = 0;
    /** Operator type */
    public const OPERATOR_EQUAL = 1;
    /** Operator type */
    public const OPERATOR_NOT_EQUAL = 2;
    /** Operator type */
    public const OPERATOR_GREATER = 3;
    /** Operator type */
    public const OPERATOR_GREATER_EQUAL = 4;
    /** Operator type */
    public const OPERATOR_LESS = 5;
    /** Operator type */
    public const OPERATOR_LESS_EQUAL = 6;
    /** Operator type */
    public const OPERATOR_LIKE = 7;
    /** Operator type */
    public const OPERATOR_NOT_LIKE = 8;
    /** Operator type */
    public const OPERATOR_BETWEEN = 9;
    /** Operator type */
    public const OPERATOR_NOT_BETWEEN = 10;
    /** Operator type */
    public const OPERATOR_IN = 11;
    /** Operator type */
    public const OPERATOR_NOT_IN = 12;
    /** Operator type */
    public const OPERATOR_NULL = 13;
    /** Operator type */
    public const OPERATOR_NOT_NULL = 14;

    /**
     * Clause comparison value
     */
    private $value;

    /**
     * Clause conjunctive
     */
    private $conjunctive;

    /**
     * Conjunctive for build nested clause
     */
    private $level;

    /** Conjunctive type */
    public const CONJUNCTIVE_NONE = 0;
    /** Conjunctive type */
    public const CONJUNCTIVE_AND = 1;
    /** Conjunctive type */
    public const CONJUNCTIVE_OR = 2;
    /** Conjunctive type */
    public const CONJUNCTIVE_NOT_AND = 3;
    /** Conjunctive type */
    public const CONJUNCTIVE_NOT_OR = 4;

    /**
     * Constructor. Clear all properties
     */
    public function __construct($column, int $operator, $value, int $conjunctive, int $level)
    {
        $this->column = $column;
        $this->operator = ($operator >= 1 && $operator <= 14) ? $operator : self::OPERATOR_DEFAULT;
        $this->value = $value;
        $this->conjunctive = ($conjunctive >= 0 && $conjunctive <= 4) ? $conjunctive : self::CONJUNCTIVE_NONE;
        $this->level = $level;
    }

    /** Get clause column */
    public function column()
    {
        return $this->column;
    }

    /** Get operator type */
    public function operator(): int
    {
        return $this->operator;
    }

    /** Get clause comparison value */
    public function value()
    {
        return $this->value;
    }

    /** Get clause conjunctive type */
    public function conjunctive(): int
    {
        return $this->conjunctive;
    }

    /** Get or set nested clause level. Negative for open parenthesis and positive for close parenthesis */
    public function level(int $input = -1): int
    {
        if ($input > -1) {
            $this->level = $input;
        }
        return $this->level;
    }

    /**
     * Create Clause object from column input, operator, value, and conjunctive for WHERE or HAVING query
     */
    public static function create(int $clauseType, $column, $operator, $value, int $conjunctive): Clause
    {
        if ($column instanceof Expression) {
            $columnObject = $column;
        } else {
            $columnObject = Column::create($column);
        }
        $validOperator = self::getOperator($operator);
        $validValue = self::getValue($value, $validOperator);
        $conjunctive = self::getConjunctive($clauseType, $conjunctive);
        $nestedLevel = self::$nestedLevel;
        self::$clauseType = $clauseType;
        self::$nestedLevel = 0;
        return new Clause($columnObject, $validOperator, $validValue, $conjunctive, $nestedLevel);
    }

    /**
     * Get a valid operator option from input operator
     */
    private static function getOperator($operator): int
    {
        if (is_int($operator)) {
            $validOperator = $operator;
        } else {
            switch ($operator) {
                case '=':
                case '==':
                    $validOperator = Clause::OPERATOR_EQUAL;
                break;
                case '!=':
                case '<>':
                    $validOperator = Clause::OPERATOR_NOT_EQUAL;
                break;
                case '>':
                    $validOperator = Clause::OPERATOR_GREATER;
                break;
                case '>=':
                    $validOperator = Clause::OPERATOR_GREATER_EQUAL;
                break;
                case '<':
                    $validOperator = Clause::OPERATOR_LESS;
                break;
                case '<=':
                    $validOperator = Clause::OPERATOR_LESS_EQUAL;
                break;
                case 'BETWEEN':
                    $validOperator = Clause::OPERATOR_BETWEEN;
                break;
                case 'NOT BETWEEN':
                    $validOperator = Clause::OPERATOR_NOT_BETWEEN;
                break;
                case 'LIKE':
                    $validOperator = Clause::OPERATOR_LIKE;
                break;
                case 'NOT LIKE':
                    $validOperator = Clause::OPERATOR_NOT_LIKE;
                break;
                case 'IN':
                    $validOperator = Clause::OPERATOR_IN;
                break;
                case 'NOT IN':
                    $validOperator = Clause::OPERATOR_NOT_IN;
                break;
                case 'NULL':
                case 'IS NULL':
                    $validOperator = Clause::OPERATOR_NULL;
                break;
                case 'NOT NULL':
                case 'IS NOT NULL':
                    $validOperator = Clause::OPERATOR_NOT_NULL;
                break;
                default:
                    $validOperator = Clause::OPERATOR_DEFAULT;
            }
        }
        return $validOperator;
    }

    /**
     * Check and get valid clause comparison value
     */
    private static function getValue($value, int $operator)
    {
        switch ($operator) {
            case Clause::OPERATOR_BETWEEN:
            case Clause::OPERATOR_NOT_BETWEEN:
                $valid = (is_array($value) && count($value) >= 2) ? true : false;
                break;
            case Clause::OPERATOR_IN:
            case Clause::OPERATOR_NOT_IN:
                $valid = is_array($value) ? true : false;
            default:
                $valid = true;
        }
        if ($valid) {
            return $value;
        } else {
            throw new \Exception('Invalid input value for Where or Having clause');
        }
    }

    /**
     * Get appropriate conjunctive from input conjunctive
     */
    private static function getConjunctive(int $clauseType, int $conjunctive)
    {
        if ($clauseType == self::$clauseType) {
            if ($conjunctive == Clause::CONJUNCTIVE_NONE) {
                if (self::$nestedConjunctive == Clause::CONJUNCTIVE_NONE) return Clause::CONJUNCTIVE_AND;
                else return self::$nestedConjunctive;
            } else {
                return $conjunctive;
            }
        }
        return Clause::CONJUNCTIVE_NONE;
    }

}
