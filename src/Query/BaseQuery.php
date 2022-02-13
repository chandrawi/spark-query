<?php

namespace SparkLib\SparkQuery\Query;

use SparkLib\SparkQuery\QueryObject;
use SparkLib\SparkQuery\QueryTranslator;
use SparkLib\SparkQuery\Builder\SelectBuilder;

class BaseQuery
{

    /**
     * Query object. Contain result of translated builder object
     */
    private $query;

    /**
     * Builder object to manipulate in query class
     */
    protected $builder;

    /**
     * Translator from QueryBuilder class
     */
    protected $translator;

    /**
     * Binding options from QueryBuilder class
     */
    protected $bindingOption;

    /**
     * Statement callable from QueryBuilder class
     */
    protected $statement;

    /**
     * Return current state of query object
     */
    public function getQueryObject()
    {
        return $this->query;
    }

    /** 
     * Get builder object
     */
    public function getBuilder()
    {
        return $this->builder;
    }

    /**
     * Translate builder object to query object
     */
    private function translate(int $translator)
    {
        if (!($this->query instanceof QueryObject)) {
            $translator != 0 ?: $translator = $this->translator;
            $this->query = new QueryObject;
            QueryTranslator::translateBuilder($this->query, $this->builder, $translator);
        }
    }

    /**
     * Get query string of current builder object
     */
    public function query(int $translator = 0, int $bindingOption = 0)
    {
        $this->translate($translator);
        $bindingOption != 0 ?: $bindingOption = $this->bindingOption;
        return QueryTranslator::getQuery($this->query, $bindingOption);
    }

    /**
     * Get query parameters of current builder object
     */
    public function params(int $translator = 0, int $bindingOption = 0)
    {
        $this->translate($translator);
        $bindingOption != 0 ?: $bindingOption = $this->bindingOption;
        return QueryTranslator::getParams($this->query, $bindingOption);
    }

    /**
     * Return statement object from defined statement callable
     */
    public function getStatement($statementOptions = null, int $translator = 0, int $bindingOption = 0)
    {
        $query = $this->query($translator, $bindingOption);
        $params = $this->params($translator, $bindingOption);
        $fetchable = ($this instanceof SelectBuilder) ? true : false;
        if (is_callable($this->statement)) {
            return call_user_func_array($this->statement, [$query, $params, $fetchable, $statementOptions]);
        } else {
            throw new \Exception('Statement callable function was not defined');
        }
    }

}
