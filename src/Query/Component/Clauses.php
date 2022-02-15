<?php

namespace SparkLib\SparkQuery\Query\Component;

use SparkLib\SparkQuery\Structure\Clause;
use SparkLib\SparkQuery\Interfaces\Iwhere;
use SparkLib\SparkQuery\Interfaces\IHaving;

/**
 * Clause manipulation component.
 * Used for WHERE and HAVING query.
 */
trait Clauses
{

    /**
     * Reset Clause object static properties
     */
    public function resetClause()
    {
        Clause::$clauseType = Clause::NONE;
        Clause::$nestedConjunctive = Clause::CONJUNCTIVE_NONE;
        Clause::$nestedLevel = 0;
    }

    /**
     * Add Clause object to where or having property of builder object
     */
    private function clauses($column, int $operator, $values, int $conjunctive)
    {
        $clauseType = Clause::$clauseType;
        if ($clauseType === Clause::NONE) {
            $clauseType = Clause::WHERE;
        }
        $clauseObject = Clause::create($clauseType, $column, $operator, $values, $conjunctive);
        if ($this->builder instanceof Iwhere or $this->buiilder instanceof IHaving) {
            if (Clause::$clauseType == Clause::HAVING) {
                $this->builder->addHaving($clauseObject);
            } else {
                $this->builder->addWhere($clauseObject);
            }
        } else {
            throw new \Exception('Builder object does not support WHERE or HAVING query');
        }
        return $this;
    }

    /** WHERE or HAVING clause query with "=" operator and AND conjunctive */
    public function equal($column, $values)
    {
        return $this->clauses($column, Clause::OPERATOR_EQUAL, $values, Clause::CONJUNCTIVE_AND);
    }

    /** WHERE or HAVING clause query with "=" operator and OR conjunctive */
    public function orEqual($column, $values)
    {
        return $this->clauses($column, Clause::OPERATOR_EQUAL, $values, Clause::CONJUNCTIVE_OR);
    }

    /** WHERE or HAVING clause query with "!=" operator and AND conjunctive */
    public function notEqual($column, $values)
    {
        return $this->clauses($column, Clause::OPERATOR_NOT_EQUAL, $values, Clause::CONJUNCTIVE_AND);
    }

    /** WHERE or HAVING clause query with "!=" operator and OR conjunctive */
    public function notOrEqual($column, $values)
    {
        return $this->clauses($column, Clause::OPERATOR_NOT_EQUAL, $values, Clause::CONJUNCTIVE_OR);
    }

    /** WHERE or HAVING clause query with ">" operator and AND conjunctive */
    public function greater($column, $values)
    {
        return $this->clauses($column, Clause::OPERATOR_GREATER, $values, Clause::CONJUNCTIVE_AND);
    }

    /** WHERE or HAVING clause query with ">" operator and OR conjunctive */
    public function orGreater($column, $values)
    {
        return $this->clauses($column, Clause::OPERATOR_GREATER, $values, Clause::CONJUNCTIVE_OR);
    }

    /** WHERE or HAVING clause query with ">=" operator and AND conjunctive */
    public function greaterEqual($column, $values)
    {
        return $this->clauses($column, Clause::OPERATOR_GREATER_EQUAL, $values, Clause::CONJUNCTIVE_AND);
    }

    /** WHERE or HAVING clause query with ">=" operator and OR conjunctive */
    public function orGreaterEqual($column, $values)
    {
        return $this->clauses($column, Clause::OPERATOR_GREATER_EQUAL, $values, Clause::CONJUNCTIVE_OR);
    }

    /** WHERE or HAVING clause query with "<" operator and AND conjunctive */
    public function less($column, $values)
    {
        return $this->clauses($column, Clause::OPERATOR_LESS, $values, Clause::CONJUNCTIVE_AND);
    }

    /** WHERE or HAVING clause query with "<" operator and OR conjunctive */
    public function orLess($column, $values)
    {
        return $this->clauses($column, Clause::OPERATOR_LESS, $values, Clause::CONJUNCTIVE_OR);
    }

    /** WHERE or HAVING clause query with "<=" operator and AND conjunctive */
    public function lessEqual($column, $values)
    {
        return $this->clauses($column, Clause::OPERATOR_LESS_EQUAL, $values, Clause::CONJUNCTIVE_AND);
    }

    /** WHERE or HAVING clause query with "<=" operator and OR conjunctive */
    public function orlessEqual($column, $values)
    {
        return $this->clauses($column, Clause::OPERATOR_LESS_EQUAL, $values, Clause::CONJUNCTIVE_OR);
    }

    /** WHERE or HAVING clause query with BETWEEN operator and AND conjunctive */
    public function between($column, $values)
    {
        return $this->clauses($column, Clause::OPERATOR_BETWEEN, $values, Clause::CONJUNCTIVE_AND);
    }

    /** WHERE or HAVING clause query with BETWEEN operator and OR conjunctive */
    public function orBetween($column, $values)
    {
        return $this->clauses($column, Clause::OPERATOR_BETWEEN, $values, Clause::CONJUNCTIVE_OR);
    }

    /** WHERE or HAVING clause query with NOT BETWEEN operator and AND conjunctive */
    public function notBetween($column, $values)
    {
        return $this->clauses($column, Clause::OPERATOR_NOT_BETWEEN, $values, Clause::CONJUNCTIVE_AND);
    }

    /** WHERE or HAVING clause query with NOT BETWEEN operator and OR conjunctive */
    public function notOrBetween($column, $values)
    {
        return $this->clauses($column, Clause::OPERATOR_NOT_BETWEEN, $values, Clause::CONJUNCTIVE_OR);
    }

    /** WHERE or HAVING clause query with IN operator and AND conjunctive */
    public function in($column, $values)
    {
        return $this->clauses($column, Clause::OPERATOR_IN, $values, Clause::CONJUNCTIVE_AND);
    }

    /** WHERE or HAVING clause query with IN operator and OR conjunctive */
    public function orIn($column, $values)
    {
        return $this->clauses($column, Clause::OPERATOR_IN, $values, Clause::CONJUNCTIVE_OR);
    }

    /** WHERE or HAVING clause query with NOT IN operator and AND conjunctive */
    public function notIn($column, $values)
    {
        return $this->clauses($column, Clause::OPERATOR_NOT_IN, $values, Clause::CONJUNCTIVE_AND);
    }

    /** WHERE or HAVING clause query with NOT IN operator and OR conjunctive */
    public function notOrIn($column, $values)
    {
        return $this->clauses($column, Clause::OPERATOR_NOT_IN, $values, Clause::CONJUNCTIVE_OR);
    }

    /** WHERE or HAVING clause query with IS NULL operator and AND conjunctive */
    public function isNull($column)
    {
        return $this->clauses($column, Clause::OPERATOR_NULL, null, Clause::CONJUNCTIVE_AND);
    }

    /** WHERE or HAVING clause query with IS NULL operator and OR conjunctive */
    public function orIsNull($column)
    {
        return $this->clauses($column, Clause::OPERATOR_NULL, null, Clause::CONJUNCTIVE_OR);
    }

    /** WHERE or HAVING clause query with IS NOT NULL operator and AND conjunctive */
    public function isNotNull($column)
    {
        return $this->clauses($column, Clause::OPERATOR_NOT_NULL, null, Clause::CONJUNCTIVE_AND);
    }

    /** WHERE or HAVING clause query with IS NOT NULL operator and OR conjunctive */
    public function orIsNotNull($column)
    {
        return $this->clauses($column, Clause::OPERATOR_NOT_NULL, null, Clause::CONJUNCTIVE_OR);
    }

}
