<?php

namespace SparkLib\SparkQuery\Query\Component;

use SparkLib\SparkQuery\Structure\Clause;
use SparkLib\SparkQuery\Structure\Expression;
use SparkLib\SparkQuery\Interfaces\Iwhere;

trait Where
{

    public function beginWhere()
    {
        Clause::$nestedConjunctive = Clause::CONJUNCTIVE_NONE;
        Clause::$nestedLevel--;
        return $this;
    }

    public function beginAndWhere()
    {
        Clause::$nestedConjunctive = Clause::CONJUNCTIVE_AND;
        Clause::$nestedLevel--;
        return $this;
    }

    public function beginOrWhere()
    {
        Clause::$nestedConjunctive = Clause::CONJUNCTIVE_OR;
        Clause::$nestedLevel--;
        return $this;
    }

    public function beginNotAndWhere()
    {
        Clause::$nestedConjunctive = Clause::CONJUNCTIVE_NOT_AND;
        Clause::$nestedLevel--;
        return $this;
    }

    public function beginNotOrWhere()
    {
        Clause::$nestedConjunctive = Clause::CONJUNCTIVE_NOT_OR;
        Clause::$nestedLevel--;
        return $this;
    }

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

    public function where($column, string $operator, $values = null)
    {
        return $this->setWhere($column, $operator, $values, Clause::CONJUNCTIVE_NONE);
    }

    public function andWhere($column, string $operator, $values = null)
    {
        return $this->setWhere($column, $operator, $values, Clause::CONJUNCTIVE_AND);
    }

    public function orWhere($column, string $operator, $values = null)
    {
        return $this->setWhere($column, $operator, $values, Clause::CONJUNCTIVE_OR);
    }

    public function notAndWhere($column, string $operator, $values = null)
    {
        return $this->setWhere($column, $operator, $values, Clause::CONJUNCTIVE_NOT_AND);
    }

    public function notOrWhere($column, string $operator, $values = null)
    {
        return $this->setWhere($column, $operator, $values, Clause::CONJUNCTIVE_NOT_OR);
    }

    public function whereExpression(string $expression, string $operator, $values = null, array $params = [])
    {
        $expressionObject = Expression::create($expression, '', $params);
        return $this->setWhere($expressionObject, $operator, $values, Clause::CONJUNCTIVE_AND);
    }

    public function orWhereExpression(string $expression, string $operator, $values = null, array $params = [])
    {
        $expressionObject = Expression::create($expression, '', $params);
        return $this->setWhere($expressionObject, $operator, $values, Clause::CONJUNCTIVE_OR);
    }

    public function notAndWhereExpression(string $expression, string $operator, $values = null, array $params = [])
    {
        $expressionObject = Expression::create($expression, '', $params);
        return $this->setWhere($expressionObject, $operator, $values, Clause::CONJUNCTIVE_NOT_AND);
    }

    public function notOrWhereExpression(string $expression, string $operator, $values = null, array $params = [])
    {
        $expressionObject = Expression::create($expression, '', $params);
        return $this->setWhere($expressionObject, $operator, $values, Clause::CONJUNCTIVE_NOT_OR);
    }

}
