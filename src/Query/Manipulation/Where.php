<?php

namespace SparkLib\SparkQuery\Query\Manipulation;

use SparkLib\SparkQuery\Query\Manipulation\BaseClause;
use SparkLib\SparkQuery\Interfaces\IWhere;
use SparkLib\SparkQuery\Structure\Column;
use SparkLib\SparkQuery\Structure\Clause;
use SparkLib\SparkQuery\Structure\Expression;

class Where extends BaseClause
{

    /**
     * Constructor.
     * Set the builder object
     */
    public function __construct($builderObject, $translator = 0, $bindingOption = 0, $statement = null)
    {
        if ($builderObject instanceof IWhere) {
            $this->builder = $builderObject;
            $this->translator = $translator;
            $this->bindingOption = $bindingOption;
            $this->statement = $statement;
        } else {
            throw new \Exception('Builder object not support Where manipulation');
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

    public function beginWhere()
    {
        Clause::$nestedConjunctive = Clause::CONJUNCTIVE_NONE;
        Clause::$nestedLevel--;
        print(Clause::$nestedLevel);exit();
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
        $lastClause = $this->builder->lastWhere();
        if ($lastClause instanceof Clause) {
            $lastLevel = $lastClause->level();
            $lastClause->level($lastLevel+1);
        }
        return $this;
    }

    /**
     * Add Clause object to where property of Builder object
     */
    public function setWhere($column, $operator, $values, int $conjunctive)
    {
        $clauseObject = Clause::create(Clause::WHERE, $column, $operator, $values, $conjunctive);
        $this->builder->addWhere($clauseObject);
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
