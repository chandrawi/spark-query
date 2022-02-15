<?php

namespace SparkLib\SparkQuery\Query;

use SparkLib\SparkQuery\QueryObject;
use SparkLib\SparkQuery\QueryTranslator;
use SparkLib\SparkQuery\Builder\SelectBuilder;

/**
 * Base of query manipulation class.
 * Must be derived for a query manipulation class.
 * Contain methods for translating query.
 */
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

    /** Tranlate query flag */
    protected $queryFlag;

    /** Tranlate params flag */
    protected $paramFlag;

    /**
     * Constructor. Reset properties
     */
    public function __construct()
    {
        $this->queryFlag = false;
        $this->paramFlag = false;
    }

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
    private function translate(int $translator = 0)
    {
        $translator != 0 ?: $translator = $this->translator;
        $this->query = new QueryObject;
        QueryTranslator::translateBuilder($this->query, $this->builder, $translator);
    }

    /**
     * Get query string of current state builder object
     */
    public function query(int $translator = 0, int $bindingOption = 0)
    {
        if ($this->queryFlag == $this->paramFlag) {
            $this->translate($translator);
        }
        $this->queryFlag = !$this->queryFlag;
        $bindingOption != 0 ?: $bindingOption = $this->bindingOption;
        return QueryTranslator::getQuery($this->query, $bindingOption);
    }

    /**
     * Get query parameters of current builder object
     */
    public function params(int $translator = 0, int $bindingOption = 0)
    {
        if ($this->queryFlag == $this->paramFlag) {
            $this->translate($translator);
        }
        $this->paramFlag = !$this->paramFlag;
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
