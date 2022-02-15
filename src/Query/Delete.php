<?php

namespace SparkLib\SparkQuery\Query;

use SparkLib\SparkQuery\Query\BaseQuery;
use SparkLib\SparkQuery\Query\Component\Clauses;
use SparkLib\SparkQuery\Query\Component\Where;
use SparkLib\SparkQuery\Query\Component\LimitOffset;
use SparkLib\SparkQuery\Builder\BaseBuilder;
use SparkLib\SparkQuery\Builder\DeleteBuilder;
use SparkLib\SparkQuery\Structure\Table;

/**
 * DELETE query manipulation class.
 */
class Delete extends BaseQuery
{

    /**
     * Register methods from traits
     */
    use Clauses, Where, LimitOffset;

    /**
     * Constructor. Set builder type to delete
     */
    public function __construct($translator = 0, $bindingOption = 0, $statement = null)
    {
        parent::__construct();
        $this->builder = new DeleteBuilder();
        $this->builder->builderType(BaseBuilder::DELETE);
        $this->translator = $translator;
        $this->bindingOption = $bindingOption;
        $this->statement = $statement;
        $this->resetClause();
    }

    /**
     * DELETE query table input
     */
    public function delete($table)
    {
        if ($table) {
            $tableObject = Table::create($table);
            $this->builder->setTable($tableObject);
        } else {
            throw new \Exception('Table name is not defined');
        }
        return $this;
    }

}
