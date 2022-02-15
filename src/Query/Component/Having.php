<?php

namespace SparkLib\SparkQuery\Query\Component;

use SparkLib\SparkQuery\Structure\Clause;
use SparkLib\SparkQuery\Structure\Expression;
use SparkLib\SparkQuery\Interfaces\IHaving;

/**
 * HAVING clause manipulation component.
 * Used for HAVING query.
 */
trait Having
{

    /** Begin a nested HAVING clause */
    public function beginHaving()
    {
        Clause::$nestedConjunctive = Clause::CONJUNCTIVE_NONE;
        Clause::$nestedLevel--;
        return $this;
    }

    /** Begin a nested HAVING clause AND conjunctive */
    public function beginAndHaving()
    {
        Clause::$nestedConjunctive = Clause::CONJUNCTIVE_AND;
        Clause::$nestedLevel--;
        return $this;
    }

    /** Begin a nested HAVING clause OR conjunctive */
    public function beginOrHaving()
    {
        Clause::$nestedConjunctive = Clause::CONJUNCTIVE_OR;
        Clause::$nestedLevel--;
        return $this;
    }

    /** Begin a nested HAVING clause NOT AND conjunctive */
    public function beginNotAndHaving()
    {
        Clause::$nestedConjunctive = Clause::CONJUNCTIVE_NOT_AND;
        Clause::$nestedLevel--;
        return $this;
    }

    /** Begin a nested HAVING clause NOT OR conjunctive */
    public function beginNotOrHaving()
    {
        Clause::$nestedConjunctive = Clause::CONJUNCTIVE_NOT_OR;
        Clause::$nestedLevel--;
        return $this;
    }

    /** End a nested HAVING clause */
    public function endHaving()
    {
        if ($this->builder instanceof IHaving) {
            $lastClause = $this->builder->lastHaving();
            if ($lastClause !== null) {
                $lastLevel = $lastClause->level();
                $lastClause->level($lastLevel+1);
            }
        }
        return $this;
    }

    /**
     * Add Clause object to having property of Builder object
     */
    private function setHaving($column, $operator, $values, int $conjunctive)
    {
        $clauseObject = Clause::create(Clause::HAVING, $column, $operator, $values, $conjunctive);
        if ($this->builder instanceof IHaving) {
            $this->builder->addHaving($clauseObject);
        } else {
            throw new \Exception('Builder object does not support HAVING query');
        }
        return $this;
    }

    /** HAVING clause query without conjunctive */
    public function having($column, string $operator, $values = null)
    {
        return $this->setHaving($column, $operator, $values, Clause::CONJUNCTIVE_NONE);
    }

    /** HAVING clause query with AND conjunctive */
    public function andHaving($column, string $operator, $values = null)
    {
        return $this->setHaving($column, $operator, $values, Clause::CONJUNCTIVE_AND);
    }

    /** HAVING clause query with OR conjunctive */
    public function orHaving($column, string $operator, $values = null)
    {
        return $this->setHaving($column, $operator, $values, Clause::CONJUNCTIVE_OR);
    }

    /** HAVING clause query with NOT AND conjunctive */
    public function notAndHaving($column, string $operator, $values = null)
    {
        return $this->setHaving($column, $operator, $values, Clause::CONJUNCTIVE_NOT_AND);
    }

    /** HAVING clause query with NOT OR conjunctive */
    public function notOrHaving($column, string $operator, $values = null)
    {
        return $this->setHaving($column, $operator, $values, Clause::CONJUNCTIVE_NOT_OR);
    }

    /** HAVING expression query with AND conjunctive */
    public function havingExpression(string $expression, string $operator, $values = null, array $params = [])
    {
        $expressionObject = Expression::create($expression, '', $params);
        return $this->setHaving($expressionObject, $operator, $values, Clause::CONJUNCTIVE_AND);
    }

    /** HAVING expression query with OR conjunctive */
    public function orHavingExpression(string $expression, string $operator, $values = null, array $params = [])
    {
        $expressionObject = Expression::create($expression, '', $params);
        return $this->setHaving($expressionObject, $operator, $values, Clause::CONJUNCTIVE_OR);
    }

    /** HAVING expression query with NOT AND conjunctive */
    public function notAndHavingExpression(string $expression, string $operator, $values = null, array $params = [])
    {
        $expressionObject = Expression::create($expression, '', $params);
        return $this->setHaving($expressionObject, $operator, $values, Clause::CONJUNCTIVE_NOT_AND);
    }

    /** HAVING expression query with NOT OR conjunctive */
    public function notOrHavingExpression(string $expression, string $operator, $values = null, array $params = [])
    {
        $expressionObject = Expression::create($expression, '', $params);
        return $this->setHaving($expressionObject, $operator, $values, Clause::CONJUNCTIVE_NOT_OR);
    }

}
