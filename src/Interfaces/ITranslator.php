<?php

namespace SparkLib\SparkQuery\Interfaces;

use SparkLib\SparkQuery\QueryObject;
use SparkLib\SparkQuery\Builder\SelectBuilder;
use SparkLib\SparkQuery\Builder\InsertBuilder;
use SparkLib\SparkQuery\Builder\UpdateBuilder;
use SparkLib\SparkQuery\Builder\DeleteBuilder;

interface ITranslator
{

    /**
     * Constructor
     * @param QueryObject $query
     */
    public function __construct(QueryObject $query);

    /**
     * Translate select builder object to SELECT query object
     * @param QueryObject $query
     * @param SelectBuilder $builder
     */
    public function translateSelect(QueryObject $query, SelectBuilder $builder);

    /**
     * Translate insert builder object to INSERT query object
     * @param QueryObject $query
     * @param InsertBuilder $builder
     */
    public function translateInsert(QueryObject $query, InsertBuilder $builder);

    /**
     * Translate update builder object to UPDATE query object
     * @param QueryObject $query
     * @param UpdateBuilder $builder
     */
    public function translateUpdate(QueryObject $query, UpdateBuilder $builder);

    /**
     * Translate delete builder object to DELETE query object
     * @param QueryObject $query
     * @param DeleteBuilder $builder
     */
    public function translateDelete(QueryObject $query, DeleteBuilder $builder);

}
