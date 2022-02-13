<?php

namespace SparkLib\SparkQuery\Query\Component;

use SparkLib\SparkQuery\Structure\Clause;

trait Clauses
{

    /**
     * Add Clause object to where or having property of Builder object
     */
    protected function clauses($column, int $operator, $values, int $conjunctive)
    {
        $clauseType = Clause::$clauseType;
        if ($clauseType === Clause::NONE) {
            $clauseType = Clause::WHERE;
        }
        $clauseObject = Clause::create($clauseType, $column, $operator, $values, $conjunctive);
        if (Clause::$clauseType == Clause::HAVING) {
            $this->builder->addHaving($clauseObject);
        } else {
            $this->builder->addWhere($clauseObject);
        }
        return $this;
    }

    public function equal($column, $values)
    {
        return $this->clauses($column, Clause::OPERATOR_EQUAL, $values, Clause::CONJUNCTIVE_AND);
    }

    public function notEqual($column, $values)
    {
        return $this->clauses($column, Clause::OPERATOR_NOT_EQUAL, $values, Clause::CONJUNCTIVE_AND);
    }

    public function orEqual($column, $values)
    {
        return $this->clauses($column, Clause::OPERATOR_EQUAL, $values, Clause::CONJUNCTIVE_OR);
    }

    public function notOrEqual($column, $values)
    {
        return $this->clauses($column, Clause::OPERATOR_NOT_EQUAL, $values, Clause::CONJUNCTIVE_OR);
    }

    public function greater($column, $values)
    {
        return $this->clauses($column, Clause::OPERATOR_GREATER, $values, Clause::CONJUNCTIVE_AND);
    }

    public function orGreater($column, $values)
    {
        return $this->clauses($column, Clause::OPERATOR_GREATER, $values, Clause::CONJUNCTIVE_OR);
    }

    public function greaterEqual($column, $values)
    {
        return $this->clauses($column, Clause::OPERATOR_GREATER_EQUAL, $values, Clause::CONJUNCTIVE_AND);
    }

    public function orGreaterEqual($column, $values)
    {
        return $this->clauses($column, Clause::OPERATOR_GREATER_EQUAL, $values, Clause::CONJUNCTIVE_OR);
    }

    public function less($column, $values)
    {
        return $this->clauses($column, Clause::OPERATOR_LESS, $values, Clause::CONJUNCTIVE_AND);
    }

    public function orLess($column, $values)
    {
        return $this->clauses($column, Clause::OPERATOR_LESS, $values, Clause::CONJUNCTIVE_OR);
    }

    public function lessEqual($column, $values)
    {
        return $this->clauses($column, Clause::OPERATOR_LESS_EQUAL, $values, Clause::CONJUNCTIVE_AND);
    }

    public function orlessEqual($column, $values)
    {
        return $this->clauses($column, Clause::OPERATOR_LESS_EQUAL, $values, Clause::CONJUNCTIVE_OR);
    }

    public function between($column, $values)
    {
        return $this->clauses($column, Clause::OPERATOR_BETWEEN, $values, Clause::CONJUNCTIVE_AND);
    }

    public function notBetween($column, $values)
    {
        return $this->clauses($column, Clause::OPERATOR_NOT_BETWEEN, $values, Clause::CONJUNCTIVE_AND);
    }

    public function orBetween($column, $values)
    {
        return $this->clauses($column, Clause::OPERATOR_BETWEEN, $values, Clause::CONJUNCTIVE_OR);
    }

    public function notOrBetween($column, $values)
    {
        return $this->clauses($column, Clause::OPERATOR_NOT_BETWEEN, $values, Clause::CONJUNCTIVE_OR);
    }

    public function in($column, $values)
    {
        return $this->clauses($column, Clause::OPERATOR_IN, $values, Clause::CONJUNCTIVE_AND);
    }

    public function notIn($column, $values)
    {
        return $this->clauses($column, Clause::OPERATOR_NOT_IN, $values, Clause::CONJUNCTIVE_AND);
    }

    public function orIn($column, $values)
    {
        return $this->clauses($column, Clause::OPERATOR_IN, $values, Clause::CONJUNCTIVE_OR);
    }

    public function notOrIn($column, $values)
    {
        return $this->clauses($column, Clause::OPERATOR_NOT_IN, $values, Clause::CONJUNCTIVE_OR);
    }

    public function isNull($column)
    {
        return $this->clauses($column, Clause::OPERATOR_NULL, null, Clause::CONJUNCTIVE_AND);
    }

    public function isNotNull($column)
    {
        return $this->clauses($column, Clause::OPERATOR_NOT_NULL, null, Clause::CONJUNCTIVE_AND);
    }

    public function orIsNull($column)
    {
        return $this->clauses($column, Clause::OPERATOR_NULL, null, Clause::CONJUNCTIVE_OR);
    }

    public function orIsNotNull($column)
    {
        return $this->clauses($column, Clause::OPERATOR_NOT_NULL, null, Clause::CONJUNCTIVE_OR);
    }

}
