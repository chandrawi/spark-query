<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once __DIR__.'/../../vendor/autoload.php';

use SparkLib\SparkQuery\QueryBuilder;
use SparkLib\SparkQuery\QueryTranslator;

$sparkQuery = new QueryBuilder(QueryTranslator::TRANSLATOR_MYSQL, QueryTranslator::PARAM_ASSOC);

$builder = $sparkQuery
    ->insert('table')
    ->values(['col1' => 'val1', 'col2' => 'val2', 'col3' => 'val3'])
;

var_dump([
    'query' => $builder->query(),
    'params' => $builder->params()
]);
