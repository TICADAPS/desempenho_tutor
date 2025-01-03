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
$ciclo = $_GET['c'];

$db = new Database($mysql_options);
$results = $db->execute_query("select d.fkperiodo, p.descricaoperiodo from demonstrativo d inner join periodo p on d.fkperiodo = p.idperiodo "
    . " where ano = '$ano' and ciclo = '$ciclo' group by fkperiodo");

echo json_encode($results, 128);