<?php

namespace SparkLib\SparkQuery;

use SparkLib\SparkQuery\Query\Select;
use SparkLib\SparkQuery\Query\Insert;
use SparkLib\SparkQuery\Query\Update;
use SparkLib\SparkQuery\Query\Delete;

class QueryBuilder
{

    /**
     * Default query translator
     */
    private int $translator;

    /**
     * Default binding mode option
     */
    private int $bindingOption;

    /**
     * Callable of statement function
     */
    public $statement;

    /**
     * Default table name
     */
    private string $table = '';

    /**
     * Constructor. Set options and create query translator object
     */
    public function __construct(int $translator = QueryTranslator::TRANSLATOR_MYSQL, int $bindingOption = QueryTranslator::PARAM_NUM)
    {
        $this->translator = $translator;
        $this->bindingOption = $bindingOption;
        $this->statement = null;
    }

    /**
     * Set statement function to connect this QueryBuilder library to a Database driver
     * @param Callable $statement
     */
    public function setStatement(Callable $statement)
    {
        $this->statement = $statement;
    }

    /**
     * Set table name
     * @param string $table
     * @return this
     */
    public function setTable(string $table)
    {
        $this->table = $table;
        return $this;
    }

    /**
     * begin SELECT query builder
     * @param mixed $table
     * @return this
     */
    public function select($table = null)
    {
        $table !== null ?: $table = $this->table;
        $selectQuery = new Select($this->translator, $this->bindingOption, $this->statement);
        return $selectQuery->select($table);
    }

    /**
     * begin SELECT DISTINCT query builder
     * @param mixed $table
     * @return this
     */
    public function selectDistinct($table = null)
    {
        $table !== null ?: $table = $this->table;
        $selectQuery = new Select($this->translator, $this->bindingOption, $this->statement);
        return $selectQuery->selectDistinct($table);
    }

    /**
     * begin INSERT INTO query builder
     * @param mixed $table
     * @return this
     */
    public function insert($table = null)
    {
        $table !== null ?: $table = $this->table;
        $insertQuery = new Insert($this->translator, $this->bindingOption, $this->statement);
        return $insertQuery->insert($table);
    }

    /**
     * begin INSERT INTO SELECT query builder
     * @param mixed $table
     * @return this
     */
    public function insertCopy($table = null)
    {
        $table !== null ?: $table = $this->table;
        $insertQuery = new Insert($this->translator, $this->bindingOption, $this->statement);
        return $insertQuery->insertCopy($table);
    }

    /**
     * begin UPDATE query builder
     * @param mixed $table
     * @return this
     */
    public function update($table = null)
    {
        $table !== null ?: $table = $this->table;
        $updateQuery = new Update($this->translator, $this->bindingOption, $this->statement);
        return $updateQuery->update($table);
    }

    /**
     * begin DELETE query builder
     * @param mixed $table
     * @return this
     */
    public function delete($table = null)
    {
        $table !== null ?: $table = $this->table;
        $deleteQuery = new Delete($this->translator, $this->bindingOption, $this->statement);
        return $deleteQuery->delete($table);
    }

}
