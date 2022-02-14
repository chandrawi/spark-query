<?php

namespace SparkLib\SparkQuery\Builder;

use SparkLib\SparkQuery\Builder\BaseBuilder;
use SparkLib\SparkQuery\Builder\Component\JoinBuilder;
use SparkLib\SparkQuery\Builder\Component\WhereBuilder;
use SparkLib\SparkQuery\Builder\Component\LimitBuilder;
use SparkLib\SparkQuery\Interfaces\IJoin;
use SparkLib\SparkQuery\Interfaces\IWhere;
use SparkLib\SparkQuery\Interfaces\ILimit;

class UpdateBuilder extends BaseBuilder implements IJoin, IWhere, ILimit
{

    /**
     * Register builder methods and properties from traits
     */
    use JoinBuilder, WhereBuilder, LimitBuilder;

}
