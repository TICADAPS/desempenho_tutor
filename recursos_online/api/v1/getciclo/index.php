<?php

require_once('../config.php');
require_once('../../libs/Database.php');

$mysql_options = [
    'host' => MYSQL_HOST,
    'database' => MYSQL_DATABASE,
    'username' => MYSQL_USERNAME,
    'password' => MYSQL_PASSWORD,
];

$ano = $_GET['a'];

$db = new Database($mysql_options);
$results = $db->execute_query("select ciclo from anocicloavaliacao where ano = '$ano'");

echo json_encode($results, 128);