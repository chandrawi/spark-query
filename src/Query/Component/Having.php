<?php

namespace SparkLib\SparkQuery\Query\Component;

use SparkLib\SparkQuery\Structure\Clause;
use SparkLib\SparkQuery\Structure\Expression;
use SparkLib\SparkQuery\Interfaces\IHaving;

trait Having
{

    public function beginHaving()
    {
        Clause::$nestedConjunctive = Clause::CONJUNCTIVE_NONE;
        Clause::$nestedLevel--;
        return $this;
    }

    public function beginAndHaving()
    {
        Clause::$nestedConjunctive = Clause::CONJUNCTIVE_AND;
        Clause::$nestedLevel--;
        return $this;
    }

    public function beginOrHaving()
    {
        Clause::$nestedConjunctive = Clause::CONJUNCTIVE_OR;
        Clause::$nestedLevel--;
        return $this;
    }

    public function beginNotAndHaving()
    {
        Clause::$nestedConjunctive = Clause::CONJUNCTIVE_NOT_AND;
        Clause::$nestedLevel--;
        return $this;
    }

    public function beginNotOrHaving()
    {
        Clause::$nestedConjunctive = Clause::CONJUNCTIVE_NOT_OR;
        Clause::$nestedLevel--;
        return $this;
    }

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

    public function having($column, string $operator, $values = null)
    {
        return $this->setHaving($column, $operator, $values, Clause::CONJUNCTIVE_NONE);
    }

    public function andHaving($column, string $operator, $values = null)
    {
        return $this->setHaving($column, $operator, $values, Clause::CONJUNCTIVE_AND);
    }

    public function orHaving($column, string $operator, $values = null)
    {
        return $this->setHaving($column, $operator, $values, Clause::CONJUNCTIVE_OR);
    }

    public function notAndHaving($column, string $operator, $values = null)
    {
        return $this->setHaving($column, $operator, $values, Clause::CONJUNCTIVE_NOT_AND);
    }

    public function notOrHaving($column, string $operator, $values = null)
    {
        return $this->setHaving($column, $operator, $values, Clause::CONJUNCTIVE_NOT_OR);
    }

    public function havingExpression(string $expression, string $operator, $values = null, array $params = [])
    {
        $expressionObject = Expression::create($expression, '', $params);
        return $this->setHaving($expressionObject, $operator, $values, Clause::CONJUNCTIVE_AND);
    }

    public function orHavingExpression(string $expression, string $operator, $values = null, array $params = [])
    {
        $expressionObject = Expression::create($expression, '', $params);
        return $this->setHaving($expressionObject, $operator, $values, Clause::CONJUNCTIVE_OR);
    }

    public function notAndHavingExpression(string $expression, string $operator, $values = null, array $params = [])
    {
        $expressionObject = Expression::create($expression, '', $params);
        return $this->setHaving($expressionObject, $operator, $values, Clause::CONJUNCTIVE_NOT_AND);
    }

    public function notOrHavingExpression(string $expression, string $operator, $values = null, array $params = [])
    {
        $expressionObject = Expression::create($expression, '', $params);
        return $this->setHaving($expressionObject, $operator, $values, Clause::CONJUNCTIVE_NOT_OR);
    }

}
