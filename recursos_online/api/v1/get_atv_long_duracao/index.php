<?php

require_once('../config.php');
require_once('../../libs/Database.php');

$mysql_options = [
    'host' => MYSQL_HOST,
    'database' => MYSQL_DATABASE,
    'username' => MYSQL_USERNAME,
    'password' => MYSQL_PASSWORD,
];

$db = new Database($mysql_options);
$results = $db->execute_query("select idativlongduracao as idl, descricao as descl from ativlongduracao");

echo json_encode($results, 128);