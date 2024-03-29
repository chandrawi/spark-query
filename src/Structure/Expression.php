<?php

namespace SparkLib\SparkQuery\Structure;

/**
 * Object for storing a user custom query expression.
 */
class Expression
{

    /**
     * Expression string
     */
    private $expression;

    /**
     * Alias name of expression
     */
    private $alias;

    /**
     * Params to bind with placeholders
     */
    private $params;

    /**
     * Constructor. Insert expression parts, params, and alias
     */
    public function __construct(array $expression, string $alias, array $params)
    {
        $this->expression = [];
        $this->alias = $alias;
        $this->params = [];
        $lenExp = count($expression);
        $lenPar = count($params);
        $len = $lenExp < $lenPar ? $lenExp : $lenPar;
        for ($i = 0; $i < $len; $i++) {
            $this->expression[] = $expression[$i];
            $this->params[] = $params[$i];
        }
        if (isset($expression[$len])) {
            $this->expression[] = $expression[$len];
        }
    }

    /** Get array of expression string */
    public function expression(): array
    {
        return $this->expression;
    }

    /** Get alias name of expression */
    public function alias(): string
    {
        return $this->alias;
    }

    /** Get expression parameters array */
    public function params(): array
    {
        return $this->params;
    }

    /**
     * Create Expression object used in column list, where or having clause column, or group by column
     */
    public static function create(string $expression, string $alias = '', array $params = []): Expression
    {
        $exploded = explode('?', $expression);
        $expressionObject = new Expression($exploded, $alias, $params);
        return $expressionObject;
    }

}
