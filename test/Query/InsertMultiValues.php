<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once __DIR__.'/../../vendor/autoload.php';

use SparkLib\SparkQuery\QueryBuilder;
use SparkLib\SparkQuery\QueryTranslator;

$sparkQuery = new QueryBuilder(QueryTranslator::TRANSLATOR_MYSQL, QueryTranslator::PARAM_ASSOC);

$builder = $sparkQuery
    ->insert('table')
    ->multiValues([
        ['col1' => 'val_0_1', 'col2' => 'val_0_2', 'col3' => 'val_0_3'],
        ['col1' => 'val_1_1', 'col2' => 'val_1_2', 'col3' => 'val_1_3'],
        ['col1' => 'val_2_1', 'col2' => 'val_2_2', 'col3' => 'val_2_3'],
    ])
;

echo var_export($builder->query());
echo PHP_EOL;
echo var_export($builder->params());
echo PHP_EOL;
