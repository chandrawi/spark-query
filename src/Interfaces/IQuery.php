<?php

namespace SparkLib\SparkQuery\Interfaces;

use SparkLib\SparkQuery\Builder\BaseBuilder;

interface IQuery
{

    /** 
     * Get builder object
     */
    public function getBuilder(): BaseBuilder;

}
