<?php

require_once('../config.php');
require_once('../../libs/Database.php');

$mysql_options = [
    'host' => MYSQL_HOST,
    'database' => MYSQL_DATABASE,
    'username' => MYSQL_USERNAME,
    'password' => MYSQL_PASSWORD,
];

$params = [
    ':ibge' => $_GET['ibge']
];

$db = new Database($mysql_options);
$results = $db->execute_query("SELECT * FROM medico WHERE ibge = :ibge", $params);

echo json_encode($results, 128);