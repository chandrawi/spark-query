<?php

namespace SparkLib\SparkQuery\Interfaces;

use SparkLib\SparkQuery\Structure\Table;

interface IBuilder
{

    /**
     * Get or set builder object type
     */
    public function builderType(int $type): int;

    /**
     * Get table
     */
    public function getTable(): Table;

    /**
     * Get array of columns
     */
    public function getColumns(): array;

    /**
     * Get array of value pairs
     */
    public function getValues(): array;

}
