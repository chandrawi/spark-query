<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once __DIR__.'/../../vendor/autoload.php';

use SparkLib\SparkQuery\QueryBuilder;
use SparkLib\SparkQuery\QueryTranslator;

$sparkQuery = new QueryBuilder(QueryTranslator::TRANSLATOR_MYSQL, QueryTranslator::PARAM_ASSOC);

$builder = $sparkQuery
    ->update('table')
    ->set(['col1' => 'val1', 'col2' => 'val2', 'col3' => 'val3'])
;

echo var_export($builder->query());
echo PHP_EOL;
echo var_export($builder->params());
echo PHP_EOL;
