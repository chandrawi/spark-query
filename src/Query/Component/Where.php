<?php

namespace SparkLib\SparkQuery\Query\Component;

use SparkLib\SparkQuery\Structure\Clause;
use SparkLib\SparkQuery\Structure\Expression;
use SparkLib\SparkQuery\Interfaces\Iwhere;

/**
 * WHERE clause manipulation component.
 * Used for WHERE query.
 */
trait Where
{

    /** Begin a nested WHERE clause */
    public function beginWhere()
    {
        Clause::$nestedConjunctive = Clause::CONJUNCTIVE_NONE;
        Clause::$nestedLevel--;
        return $this;
    }

    /** Begin a nested WHERE clause with AND conjunctive */
    public function beginAndWhere()
    {
        Clause::$nestedConjunctive = Clause::CONJUNCTIVE_AND;
        Clause::$nestedLevel--;
        return $this;
    }

    /** Begin a nested WHERE clause with OR conjunctive */
    public function beginOrWhere()
    {
        Clause::$nestedConjunctive = Clause::CONJUNCTIVE_OR;
        Clause::$nestedLevel--;
        return $this;
    }

    /** Begin a nested WHERE clause with NOT AND conjunctive */
    public function beginNotAndWhere()
    {
        Clause::$nestedConjunctive = Clause::CONJUNCTIVE_NOT_AND;
        Clause::$nestedLevel--;
        return $this;
    }

    /** Begin a nested WHERE clause with NOT OR conjunctive */
    public function beginNotOrWhere()
    {
        Clause::$nestedConjunctive = Clause::CONJUNCTIVE_NOT_OR;
        Clause::$nestedLevel--;
        return $this;
    }

    /** End a nested WHERE clause */
    public function endWhere()
    {
        if ($this->builder instanceof Iwhere) {
            $lastClause = $this->builder->lastWhere();
            if ($lastClause !== null) {
                $lastLevel = $lastClause->level();
                $lastClause->level($lastLevel+1);
            }
        }
        return $this;
    }

    /**
     * Add Clause object to where property of Builder object
     */
    private function setWhere($column, $operator, $values, int $conjunctive)
    {
        $clauseObject = Clause::create(Clause::WHERE, $column, $operator, $values, $conjunctive);
        if ($this->builder instanceof Iwhere) {
            $this->builder->addWhere($clauseObject);
        } else {
            throw new \Exception('Builder object does not support WHERE query');
        }
        return $this;
    }

    /** WHERE clause query without conjunctive */
    public function where($column, string $operator, $values = null)
    {
        return $this->setWhere($column, $operator, $values, Clause::CONJUNCTIVE_NONE);
    }

    /** WHERE clause query with AND conjunctive */
    public function andWhere($column, string $operator, $values = null)
    {
        return $this->setWhere($column, $operator, $values, Clause::CONJUNCTIVE_AND);
    }

    /** WHERE clause query with OR conjunctive */
    public function orWhere($column, string $operator, $values = null)
    {
        return $this->setWhere($column, $operator, $values, Clause::CONJUNCTIVE_OR);
    }

    /** WHERE clause query with NOT AND conjunctive */
    public function notAndWhere($column, string $operator, $values = null)
    {
        return $this->setWhere($column, $operator, $values, Clause::CONJUNCTIVE_NOT_AND);
    }

    /** WHERE clause query with NOT OR conjunctive */
    public function notOrWhere($column, string $operator, $values = null)
    {
        return $this->setWhere($column, $operator, $values, Clause::CONJUNCTIVE_NOT_OR);
    }

    /** WHERE expression query with AND conjunctive */
    public function whereExpression(string $expression, string $operator, $values = null, array $params = [])
    {
        $expressionObject = Expression::create($expression, '', $params);
        return $this->setWhere($expressionObject, $operator, $values, Clause::CONJUNCTIVE_AND);
    }

    /** WHERE expression query with OR conjunctive */
    public function orWhereExpression(string $expression, string $operator, $values = null, array $params = [])
    {
        $expressionObject = Expression::create($expression, '', $params);
        return $this->setWhere($expressionObject, $operator, $values, Clause::CONJUNCTIVE_OR);
    }

    /** WHERE expression query with NOT AND conjunctive */
    public function notAndWhereExpression(string $expression, string $operator, $values = null, array $params = [])
    {
        $expressionObject = Expression::create($expression, '', $params);
        return $this->setWhere($expressionObject, $operator, $values, Clause::CONJUNCTIVE_NOT_AND);
    }

    /** WHERE expression query with NOT OR conjunctive */
    public function notOrWhereExpression(string $expression, string $operator, $values = null, array $params = [])
    {
        $expressionObject = Expression::create($expression, '', $params);
        return $this->setWhere($expressionObject, $operator, $values, Clause::CONJUNCTIVE_NOT_OR);
    }

}
