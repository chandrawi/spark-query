<?php

namespace SparkLib\SparkQuery\Builder;

use SparkLib\SparkQuery\Builder\BaseBuilder;
use SparkLib\SparkQuery\Builder\Component\JoinBuilder;
use SparkLib\SparkQuery\Builder\Component\WhereBuilder;
use SparkLib\SparkQuery\Builder\Component\HavingBuilder;
use SparkLib\SparkQuery\Builder\Component\GroupByBuilder;
use SparkLib\SparkQuery\Builder\Component\OrderByBuilder;
use SparkLib\SparkQuery\Builder\Component\LimitBuilder;
use SparkLib\SparkQuery\Interfaces\IJoin;
use SparkLib\SparkQuery\Interfaces\IWhere;
use SparkLib\SparkQuery\Interfaces\IGroupBy;
use SparkLib\SparkQuery\Interfaces\IHaving;
use SparkLib\SparkQuery\Interfaces\IOrderBy;
use SparkLib\SparkQuery\Interfaces\ILimit;

class SelectBuilder extends BaseBuilder implements IJoin, IWhere, IGroupBy, IHaving, IOrderBy, ILimit
{

    /**
     * Register builder methods and properties from traits
     */
    use JoinBuilder, WhereBuilder, HavingBuilder, GroupByBuilder, OrderByBuilder, LimitBuilder;

}
