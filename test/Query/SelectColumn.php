<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once __DIR__.'/../../vendor/autoload.php';

use SparkLib\SparkQuery\QueryBuilder;
use SparkLib\SparkQuery\QueryTranslator;

$sparkQuery = new QueryBuilder(QueryTranslator::TRANSLATOR_MYSQL, QueryTranslator::PARAM_ASSOC);

$builder = $sparkQuery
    ->select(['alias' => 'table'])
    ->column('col1')
    ->columns(['alias2' => 'col2', 'max' => 'MAX(col3)'])
    ->columns(['col4'])
;

echo var_export($builder->query());
echo PHP_EOL;
echo var_export($builder->params());
echo PHP_EOL;
