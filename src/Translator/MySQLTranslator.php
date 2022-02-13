<?php

namespace SparkLib\SparkQuery\Translator;

use SparkLib\SparkQuery\Translator\BaseTranslator;
use SparkLib\SparkQuery\QueryObject;
use SparkLib\SparkQuery\Builder\SelectBuilder;
use SparkLib\SparkQuery\Builder\InsertBuilder;
use SparkLib\SparkQuery\Builder\UpdateBuilder;
use SparkLib\SparkQuery\Builder\DeleteBuilder;

class MySQLTranslator extends BaseTranslator
{

    /** ITranslator required method */
    public function __construct(QueryObject $query)
    {
        $query->setMarkQuote('?', ':', "'");
        $this->QUOTE = "`";
        $this->EQUAL = "=";
        $this->OPEN_BRACKET = "(";
        $this->CLOSE_BRACKET = ")";
        $this->DOT = ".";
        $this->COMMA = ", ";
        $this->END_QUERY = ";";
    }

    /** ITranslator required method */
    public function translateSelect(QueryObject $query, SelectBuilder $builder)
    {
        $multiTableFlag = boolval($builder->countJoin());

        $this->firstKeyword($query, $builder->builderType());
        $this->columnsSelect($query, $builder->getColumns(), $builder->countColumns(), $multiTableFlag);
        $this->fromTable($query, $builder->getTable());
        $this->join($query, $builder->getJoin());
        $this->where($query, $builder->getWhere(), $builder->countWhere(), $multiTableFlag);
        $this->groupBy($query, $builder->getGroup(), $builder->countGroup(), $multiTableFlag);
        $this->having($query, $builder->getHaving(), $builder->countHaving(), $multiTableFlag);
        $this->orderBy($query, $builder->getOrder(), $builder->countOrder(), $multiTableFlag);
        $this->limitOffset($query, $builder->getLimit(), $builder->hasLimit());
        $query->add($this->END_QUERY);
    }

    /** ITranslator required method */
    public function translateInsert(QueryObject $query, InsertBuilder $builder)
    {
        $this->firstKeyword($query, $builder->builderType());
        $this->intoTable($query, $builder->getTable());
        $this->columnsInsert($query, $builder->getValues(), $builder->countValues());
        $this->valuesInsert($query, $builder->getValues(), $builder->countValues());
        $this->limitOffset($query, $builder->getLimit(), $builder->hasLimit());
        $query->add($this->END_QUERY);
    }

    /** ITranslator required method */
    public function translateUpdate(QueryObject $query, UpdateBuilder $builder)
    {
        $multiTableFlag = boolval($builder->countJoin());

        $this->firstKeyword($query, $builder->builderType());
        $this->tableSet($query, $builder->getTable());
        $this->join($query, $builder->getJoin());
        $this->valuesUpdate($query, $builder->getValues(), $builder->countValues(), $multiTableFlag);
        $this->where($query, $builder->getWhere(), $builder->countWhere(), $multiTableFlag);
        $this->limitOffset($query, $builder->getLimit(), $builder->hasLimit());
        $query->add($this->END_QUERY);
    }

    /** ITranslator required method */
    public function translateDelete(QueryObject $query, DeleteBuilder $builder)
    {
        $this->firstKeyword($query, $builder->builderType());
        $this->fromTable($query, $builder->getTable());
        $this->where($query, $builder->getWhere(), $builder->countWhere());
        $this->limitOffset($query, $builder->getLimit(), $builder->hasLimit());
        $query->add($this->END_QUERY);
    }

}
