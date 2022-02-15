<?php

namespace SparkLib\SparkQuery\Builder;

use SparkLib\SparkQuery\Builder\BaseBuilder;
use SparkLib\SparkQuery\Builder\Component\LimitBuilder;
use SparkLib\SparkQuery\Interfaces\ILimit;

/**
 * Template for building INSERT query
 */
class InsertBuilder extends BaseBuilder implements ILimit
{

    /**
     * Register builder methods and properties from traits
     */
    use LimitBuilder;

}
