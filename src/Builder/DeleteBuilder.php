<?php

namespace SparkLib\SparkQuery\Builder;

use SparkLib\SparkQuery\Builder\BaseBuilder;
use SparkLib\SparkQuery\Builder\Component\WhereBuilder;
use SparkLib\SparkQuery\Builder\Component\LimitBuilder;
use SparkLib\SparkQuery\Interfaces\IWhere;
use SparkLib\SparkQuery\Interfaces\ILimit;

class DeleteBuilder extends BaseBuilder implements IWhere, ILimit
{

    /**
     * Register builder methods and properties from traits
     */
    use WhereBuilder, LimitBuilder;

}
