<?php

require_once('../config.php');
require_once('../../libs/Database.php');

$mysql_options = [
    'host' => MYSQL_HOST,
    'database' => MYSQL_DATABASE,
    'username' => MYSQL_USERNAME,
    'password' => MYSQL_PASSWORD,
];

$id = $_GET['id'];

$db = new Database($mysql_options);
$results = $db->execute_query("select ap.id, ap.flagemailaviso as flagenvemail, 
    DATE_FORMAT(ap.emailaviso, '%d-%m-%Y %H:%i:%s') as dthrenvemail 
    from aperfeicoamentoprofissional ap where ap.id = '$id' limit 1");

echo json_encode($results, 128);