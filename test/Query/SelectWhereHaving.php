<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once __DIR__.'/../../vendor/autoload.php';

use SparkLib\SparkQuery\QueryBuilder;
use SparkLib\SparkQuery\QueryTranslator;

$sparkQuery = new QueryBuilder(QueryTranslator::TRANSLATOR_MYSQL, QueryTranslator::PARAM_ASSOC);

$builder = $sparkQuery
    ->select('table')
    ->where('col1', '>=', 0)
        ->beginAndWhere()
        ->where('col3', 'IN', ['value0', 'value1', 'value2'])
        ->orWhere('col4', 'BETWEEN', ['minValue', 'maxValue'])
        ->endWhere()
    ->groupBy('col1')
    ->having('col5', '=', 'havingValue')
;

echo var_export($builder->query());
echo PHP_EOL;
echo var_export($builder->params());
echo PHP_EOL;