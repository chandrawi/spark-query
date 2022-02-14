<?php

namespace SparkLib\SparkQuery\Translator;

use SparkLib\SparkQuery\QueryObject;
use SparkLib\SparkQuery\Builder\BaseBuilder;
use SparkLib\SparkQuery\Structure\Table;
use SparkLib\SparkQuery\Structure\Column;
use SparkLib\SparkQuery\Structure\Value;
use SparkLib\SparkQuery\Structure\Expression;
use SparkLib\SparkQuery\Structure\Join;
use SparkLib\SparkQuery\Structure\Clause;
use SparkLib\SparkQuery\Structure\Order;
use SparkLib\SparkQuery\Structure\Limit;

class BaseTranslator
{

    /** Quote character for enclosing table and column */
    protected $QUOTE_STRUCT = "`";

    /** Quote character for enclosing strings */
    protected $QUOTE_STRING = "'";

    /** Equal sign character */
    protected $EQUAL = "=";

    /** Open parentheses character */
    protected $OPEN_BRACKET = "(";

    /** Close parentheses character */
    protected $CLOSE_BRACKET = ")";

    /** Dot character for indicating column of table */
    protected $DOT = ".";

    /** Comma character for separating between column and value list */
    protected $COMMA = ",";

    /** End of query character */
    protected $END_QUERY = ";";

    protected function firstKeyword(QueryObject $query, $builderType)
    {
        switch ($builderType) {
            case BaseBuilder::SELECT:
                $query->add('SELECT ');
                break;
            case BaseBuilder::INSERT:
                $query->add('INSERT ');
                break;
            case BaseBuilder::UPDATE:
                $query->add('UPDATE ');
                break;
            case BaseBuilder::DELETE:
                $query->add('DELETE');
                break;
            case BaseBuilder::SELECT_DISTINCT:
                $query->add('SELECT DISTINCT ');
                break;
        }
    }

    /**
     * Create "FROM `table` AS `alias`" expression
     */
    protected function fromTable(QueryObject $query, $table)
    {
        if ($table instanceof Table) {
            $name = $table->name();
            $alias = $table->alias();

            $query->add(' FROM '. $this->QUOTE_STRUCT);
            $query->add($name);
            $query->add($this->QUOTE_STRUCT);
            if ($alias) {
                $query->add(' AS '. $this->QUOTE_STRUCT. $alias. $this->QUOTE_STRUCT);
            }
        }
    }

    /**
     * Create "INTO `table`" expression
     */
    protected function intoTable(QueryObject $query, $table)
    {
        if ($table instanceof Table) {
            $name = $table->name();

            $query->add('INTO '. $this->QUOTE_STRUCT);
            $query->add($name);
            $query->add($this->QUOTE_STRUCT);
        }
    }

    /**
     * Create "`table`" expression
     */
    protected function tableSet(QueryObject $query, $table)
    {
        if ($table instanceof Table) {
            $name = $table->name();

            $query->add($this->QUOTE_STRUCT);
            $query->add($name);
            $query->add($this->QUOTE_STRUCT);
        }
    }

    /**
     * Generate list of "FUNCTION(`table`.`column`) AS (`alias`)" for SELECT query
     */
    protected function columnsSelect(QueryObject $query, array $columns, int $count, bool $multiTableFlag = false)
    {
        if ($count == 0) {
            $query->add('*');
            return;
        }
        foreach ($columns as $column) {
            if ($column instanceof Column) {
                $table = $column->table();
                $name = $column->name();
                $alias = $column->alias();
                $function = $column->function();

                if ($function) {
                    $query->add($function. $this->OPEN_BRACKET);
                }
                $query->add($this->QUOTE_STRUCT);
                if ($table && $multiTableFlag) {
                    $query->add($table);
                    $query->add($this->QUOTE_STRUCT. $this->DOT .$this->QUOTE_STRUCT);
                }
                $query->add($name);
                $query->add($this->QUOTE_STRUCT);
                if ($function) {
                    $query->add($this->CLOSE_BRACKET);
                }
                if ($alias) {
                    $query->add(' AS '. $this->QUOTE_STRUCT. $alias. $this->QUOTE_STRUCT);
                }
            } elseif ($column instanceof Expression) {
                $this->expression($query, $column);
            }
            if (--$count > 0) $query->add($this->COMMA);
        }
    }

    /**
     * Generate list of "`column`" expression for INSERT query
     */
    protected function columnsInsert(QueryObject $query, array $values, int $count)
    {
        if ($count === 0) {
            $query->add(' '. $this->OPEN_BRACKET);
            $query->add($this->CLOSE_BRACKET);
            return;
        }

        $value = $values[0];
        if ($value instanceof Value) {
            $columns = $value->columns();
            $count = count($columns);

            $query->add(' '. $this->OPEN_BRACKET);
            foreach ($columns as $column) {
                $query->add($this->QUOTE_STRUCT);
                $query->add($column);
                $query->add($this->QUOTE_STRUCT);
                if (--$count > 0) $query->add($this->COMMA);
            }
            $query->add($this->CLOSE_BRACKET);
        }
    }

    /**
     * Create "FUNCTION(`table`.`column`)" or "FUNCTION(`alias`)" expression
     */
    protected function column(QueryObject $query, Column $column, bool $multiTableFlag = false)
    {
        $table = $column->table();
        $name = $column->name();
        $alias = $column->alias();
        $function = $column->function();

        if ($function) {
            $query->add($function. $this->OPEN_BRACKET);
        }
        if ($alias) {
            $query->add($this->QUOTE_STRUCT);
            $query->add($column->alias());
            $query->add($this->QUOTE_STRUCT);
        } else {
            $query->add($this->QUOTE_STRUCT);
            if ($table && $multiTableFlag) {
                $query->add($table);
                $query->add($this->QUOTE_STRUCT. $this->DOT. $this->QUOTE_STRUCT);
            }
            $query->add($name);
            $query->add($this->QUOTE_STRUCT);
        }
        if ($function) {
            $query->add($this->CLOSE_BRACKET);
        }
    }

    /**
     * Generate list of "FUNCTION(`table`.`column`)" or "FUNCTION(`alias`)" expression for INSERT query
     */
    protected function valuesInsert(QueryObject $query, array $values, int $count)
    {
        $query->add(' VALUES ');
        if ($count === 0) {
            $query->add($this->OPEN_BRACKET);
            $query->add($this->CLOSE_BRACKET);
            return;
        }

        foreach ($values as $value) {
            if ($value instanceof Value) {
                $vals = $value->values();
                $countVals = count($vals);

                $query->add($this->OPEN_BRACKET);
                foreach ($vals as $val) {
                    $query->add($val, true);
                    if (--$countVals > 0) $query->add($this->COMMA);
                }
                $query->add($this->CLOSE_BRACKET);
            }
            if (--$count > 0) $query->add($this->COMMA);
        }
    }

    /**
     * Generate list of "`table`.`column`=values" expression for UPDATE query
     */
    protected function valuesUpdate(QueryObject $query, array $values, int $count, bool $multiTableFlag)
    {
        $query->add(' SET ');

        foreach ($values as $value) {
            if ($value instanceof Value) {
                $table = $value->table();
                $columns = $value->columns();
                $vals = $value->values();
                $countVals = count($vals);
    
                foreach ($vals as $i => $val) {
                    $query->add($this->QUOTE_STRUCT);
                    if ($multiTableFlag) {
                        $query->add($table);
                        $query->add($this->QUOTE_STRUCT. $this->DOT. $this->QUOTE_STRUCT);
                    }
                    $query->add($columns[$i]);
                    $query->add($this->QUOTE_STRUCT. $this->EQUAL);
                    $query->add($val, true);
                    if (--$countVals > 0) $query->add($this->COMMA);
                }
            }
            if (--$count > 0) $query->add($this->COMMA);
        }
    }

    /**
     * Create user defined expression with param binding and alias
     */
    protected function expression(QueryObject $query, Expression $expression)
    {
        $params = $expression->params();
        $exps = $expression->expression();
        $alias = $expression->alias();

        foreach ($exps as $i => $exp) {
            $query->add($exp);
            if (isset($params[$i])) $query->add($params[$i], true);
        }
        if ($alias) {
            $query->add(' AS '. $this->QUOTE_STRUCT);
            $query->add($alias);
            $query->add($this->QUOTE_STRUCT);
        }
    }

    /**
     * Generate JOIN expression with join table and columns
     */
    protected function join(QueryObject $query, array $joins)
    {
        foreach ($joins as $join) {
            if ($join instanceof Join) {
                $joinType = $this->joinType($join->joinType());
                $query->add($joinType);
                $this->joinTable($query, $join->joinTable(), $join->joinAlias());
                $this->joinColumns($query, $join->baseColumns(), $join->joinColumns(), $join->usingColumns());
            }
        }
    }

    /**
     * Translate join type for join query
     */
    protected function joinType(int $joinType): string
    {
        switch ($joinType) {
            case Join::INNER_JOIN:
                return ' INNER JOIN ';
            case Join::LEFT_JOIN:
                return ' LEFT JOIN ';
            case Join::RIGHT_JOIN:
                return ' RIGHT JOIN ';
            case Join::OUTER_JOIN:
                return ' OUTER JOIN ';
            default:
                return '';
        }
    }

    /**
     * Create "`table` AS `alias`" expression for JOIN query
     */
    protected function joinTable(QueryObject $query, string $joinTable, string $joinAlias)
    {
        $query->add($this->QUOTE_STRUCT);
        $query->add($joinTable);
        if ($joinAlias) {
            $query->add($this->QUOTE_STRUCT. ' AS '. $this->QUOTE_STRUCT. $joinAlias);
        }
        $query->add($this->QUOTE_STRUCT);
    }

    /**
     * Create "USING(`column`)" or "ON `basetable`.`column`=`jointable`.`column`" expression for JOIN query
     */
    protected function joinColumns(QueryObject $query, array $baseColumns, array $joinColumns, array $usingColumns)
    {    
        $count = count($usingColumns);
        if ($count) {
            $query->add(' USING '. $this->OPEN_BRACKET);
            foreach ($usingColumns as $column) {
                $this->column($query, $column, false);
                if (--$count > 1) $query->add($this->COMMA);
            }
            $query->add($this->CLOSE_BRACKET);
        } else {
            foreach ($baseColumns as $i => $baseCol) {
                $i == 0 ? $query->add(' ON ') : $query->add(' AND ');
                $this->column($query, $baseCol, true);
                $query->add($this->EQUAL);
                $this->column($query, $joinColumns[$i], true);
            }
        }
    }

    /**
     * Translate operator for WHERE and HAVING query and comparison expression
     */
    protected function operator(int $operator): string
    {
        switch ($operator) {
            case Clause::OPERATOR_EQUAL:
                return '=';
            case Clause::OPERATOR_NOT_EQUAL:
                return '!=';
            case Clause::OPERATOR_GREATER:
                return '>';
            case Clause::OPERATOR_GREATER_EQUAL:
                return '>=';
            case Clause::OPERATOR_LESS:
                return '<';
            case Clause::OPERATOR_LESS_EQUAL:
                return '<=';
            case Clause::OPERATOR_BETWEEN:
                return ' BETWEEN ';
            case Clause::OPERATOR_NOT_BETWEEN:
                return ' NOT BETWEEN ';
            case Clause::OPERATOR_LIKE:
                return ' LIKE ';
            case Clause::OPERATOR_NOT_LIKE:
                return ' NOT LIKE ';
            case Clause::OPERATOR_IN:
                return ' IN ';
            case Clause::OPERATOR_NOT_IN:
                return ' NOT IN ';
            case Clause::OPERATOR_NULL:
                return ' IS NULL';
            case Clause::OPERATOR_NOT_NULL:
                return ' IS NOT NULL';
            default:
                return '';
        }
    }

    /**
     * Translate conjunctive for WHERE and HAVING clause query
     */
    protected function conjunctive(int $conjunctive): string
    {
        switch ($conjunctive) {
            case Clause::CONJUNCTIVE_AND:
                return ' AND ';
            case Clause::CONJUNCTIVE_OR:
                return ' OR ';
            case Clause::CONJUNCTIVE_NOT_AND:
                return ' NOT AND ';
            case Clause::CONJUNCTIVE_NOT_OR:
                return ' NOT OR ';
            default:
                return '';
        }
    }

    /**
     * Get open or close bracket based on input level
     */
    protected function brackets(int $level): string
    {
        $string = '';
        if ($level < 0) {
            for ($i=$level; $i<0; $i++) {
                $string .= $this->OPEN_BRACKET;
            }
        } elseif ($level > 0) {
            for ($i=0; $i<$level; $i++) {
                $string .= $this->CLOSE_BRACKET;
            }
        }
        return $string;
    }

    /**
     * Create "WHERE" expression and generate list of clause expression
     */
    protected function where(QueryObject $query, array $whereClauses, $count, bool $multiTableFlag = false)
    {
        if ($count) {
            $query->add(' WHERE ');
            foreach ($whereClauses as $where) {
                if ($where instanceof Clause) {
                    $conjunctive = $this->conjunctive($where->conjunctive());
                    $nestedLevel = $where->level();
    
                    $query->add($conjunctive);
                    if ($nestedLevel < 0) $query->add($this->brackets($nestedLevel));
                    $this->clause($query, $where, $multiTableFlag);
                    if ($nestedLevel > 0) $query->add($this->brackets($nestedLevel));
                }
            }
        }
    }

    /**
     * Create "HAVING" expression and generate list of clause expression
     */
    protected function having(QueryObject $query, array $havingClauses, $count, bool $multiTableFlag = false)
    {
        if ($count) {
            $query->add(' HAVING ');
            foreach ($havingClauses as $having) {
                if ($having instanceof Clause) {
                    $conjunctive = $this->conjunctive($having->conjunctive());
                    $nestedLevel = $having->level();
    
                    $query->add($conjunctive);
                    if ($nestedLevel < 0) $query->add($this->brackets($nestedLevel));
                    $this->clause($query, $having, $multiTableFlag);
                    if ($nestedLevel > 0) $query->add($this->brackets($nestedLevel));
                }
            }
        }
    }

    /**
     * Create clause expression which contain column, operator, and value
     */
    protected function clause(QueryObject $query, $clause, bool $multiTableFlag = false)
    {
        if ($clause instanceof Clause) {
            $column = $clause->column();
            $operator = $clause->operator();
            $values = $clause->value();

            if ($column instanceof Column) {
                $this->column($query, $column, $multiTableFlag);
            } elseif ($column instanceof Expression) {
                $this->expression($query, $column);
            }
            switch ($operator) {
                case Clause::OPERATOR_BETWEEN:
                case Clause::OPERATOR_NOT_BETWEEN:
                    $this->clauseBetween($query, $operator, $values);
                    break;
                case Clause::OPERATOR_IN:
                case Clause::OPERATOR_NOT_IN:
                    $this->clauseIn($query, $operator, $values);
                    break;
                default:
                    $this->clauseComparison($query, $operator, $values);
                    break;
            }
        }
    }

    /**
     * Create comparison expression in clause expression
     */
    protected function clauseComparison(QueryObject $query, int $operator, $values)
    {
        $operatorString = $this->operator($operator);
        $query->add($operatorString);
        if ($operator !== Clause::OPERATOR_NULL && $operator !== Clause::OPERATOR_NOT_NULL) {
            $query->add($values, true);
        }
    }

    /**
     * Create between expression in clause expression
     */
    protected function clauseBetween(QueryObject $query, int $operator, array $values)
    {
        $operatorString = $this->operator($operator);
        $query->add($operatorString);
        $query->add($values[0], true);
        $query->add(' AND ');
        $query->add($values[1], true);
    }

    /**
     * Create in expression in clause expression
     */
    protected function clauseIn(QueryObject $query, int $operator, array $values)
    {
        $operatorString = $this->operator($operator);
        $query->add($operatorString. $this->OPEN_BRACKET);
        $count = count($values);
        foreach ($values as $value) {
            $query->add($value, true);
            (--$count < 1) ?: $query->add($this->COMMA);
        }
        $query->add($this->CLOSE_BRACKET);
    }

    /**
     * Create "GROUP BY " expression and generate list of column expression
     */
    protected function groupBy(QueryObject $query, array $groups, int $count, bool $multiTableFlag = false)
    {
        if ($count) {
            $query->add(' GROUP BY ');
            foreach ($groups as $group) {
                $this->column($query, $group, $multiTableFlag);
                if (--$count > 1) $query->add($this->COMMA);
            }
        }
    }

    /**
     * Create "ORDER BY `column` ASC|DESC" expression
     */
    protected function orderBy(QueryObject $query, array $orders, int $count, bool $multiTableFlag = false)
    {
        if ($count) {
            $query->add(' ORDER BY ');
            foreach ($orders as $order) {
                $column = $order->column();
                $this->column($query, $column, $multiTableFlag);

                switch ($order->orderType()) {
                    case Order::ORDER_ASC:
                        $query->add(' ASC');
                        break;
                    case Order::ORDER_DESC:
                        $query->add(' DESC');
                }
                (--$count < 1) ?: $query->add($this->COMMA);
            }
        }
    }

    /**
     * Create "OFFSET offsetValue" or "LIMIT limitValue, offsetValue" expression
     */
    protected function limitOffset(QueryObject $query, $limitOffset, bool $hasLimit)
    {
        if ($hasLimit) {
            $limit = $limitOffset->limit();
            $offset = $limitOffset->offset();
            if ($limit == Limit::NOT_SET) {
                $query->add(' OFFSET ');
                $query->add($offset, true);
            } else {
                $query->add(' LIMIT ');
                $query->add($limit, true);
                if ($offset != Limit::NOT_SET) {
                    $query->add($this->COMMA);
                    $query->add($offset, true);
                }
            }
        }
    }

}
