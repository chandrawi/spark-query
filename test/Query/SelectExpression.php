<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once __DIR__.'/../../vendor/autoload.php';

use SparkLib\SparkQuery\QueryBuilder;
use SparkLib\SparkQuery\QueryTranslator;

$sparkQuery = new QueryBuilder(QueryTranslator::TRANSLATOR_MYSQL, QueryTranslator::PARAM_ASSOC);

$builder = $sparkQuery
    ->select('table')
    ->columnExpression("CONCAT_WS(?, `col1`, `col2`, `col3`)", 'cols', ['-'])
    ->column('col4')
    ->where('col1', '=', 'value1')
    ->whereExpression("UNIX_TIMESTAMP(`datetime`)%?", '=', 0, [3600])
;

var_dump([
    'query' => $builder->query(),
    'params' => $builder->params()
]);
